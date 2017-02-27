<?php
declare(strict_types = 1);

require_once __DIR__.'/../vendor/autoload.php';

use Strayobject\App\Application;
use Silex\Provider\TwigServiceProvider;
use Strayobject\Cravc\Action\GetLatestFileAction;
use Strayobject\Cravc\Calculator\AverageCalculator;
use Strayobject\Cravc\Provider\CalculatedDataProvider;
use Strayobject\Cravc\Uploader\FileUploader;
use Strayobject\Cravc\Writer\CsvDataWriter;
use Symfony\Component\HttpFoundation\Request;

$rootDir = dirname(__DIR__, 1);
$app = new Application();
$app['debug'] = true;

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'twig.options' => [
        'cache' => __DIR__.'/../var/cache',
    ],
));

$app['config'] = $app->factory(function () use ($rootDir) {
    return [
        'location.root_dir' => $rootDir,
        'location.filename.processed' => 'processedAverages.csv',
        'location.filename.original' => 'originalAverages.csv',
        'location.file_storage' => sprintf('%s/var/files', $rootDir),
    ];
});

/**
 * Services
 */
$app['calculator.average'] = function () {
    return new AverageCalculator();
};

$app['uploader.file'] = function () use ($app) {
    return new FileUploader($app['config']['location.file_storage']);
};

$app['provider.calculated_data'] = function () use ($app) {
    $readPath = sprintf(
        '%s/%s',
        $app['config']['location.file_storage'],
        $app['config']['location.filename.original']
    );

    return new CalculatedDataProvider($readPath, $app['calculator.average']);
};

$app['writer.csv_data'] = function () use ($app) {
    $writePath = sprintf(
        '%s/%s',
        $app['config']['location.file_storage'],
        $app['config']['location.filename.processed']
    );

    return new CsvDataWriter($writePath);
};


/**
 * Routes
 */
$app
    ->get('/', function () use ($app) {
        return $app->render('pages/index.html.twig');
    })
    ->bind('index')
;

$app
    ->get('/latest-calc-file', function (Request $request) use ($app) {
        $getLatestFileAction = new GetLatestFileAction(
            $app['config']['location.file_storage'],
            $app['config']['location.filename.processed']
        );

        return $getLatestFileAction($request);
    })
    ->bind('latest-calc-file')
;

$app
    ->get('/latest-uploaded-file', function (Request $request) use ($app) {
        $getLatestFileAction = new GetLatestFileAction(
            $app['config']['location.file_storage'],
            $app['config']['location.filename.original']
        );

        return $getLatestFileAction($request);
    })
    ->bind('latest-uploaded-file')
;

$app
    ->get('/upload-calc', function () use ($app) {
        return $app->render('pages/upload_calc.html.twig');
    })
    ->bind('upload-calc')
;

$app
    ->post('/upload-file', function (Request $request) use ($app) {
        $file = $request->files->get('csv_file');
        $uploader = $app['uploader.file'];
        $uploader->upload($file, $app['config']['location.filename.original']);

        $data = $app['provider.calculated_data']->getData();
        $app['writer.csv_data']->writeData($data);

        return $app->redirect('/latest-calc-file');
    })
    ->bind('upload-file')
;

$app->error(function (\Throwable $e, Request $request, $code) use ($app) {
    return $app->render('pages/index.html.twig', ['error' => $e->getMessage()]);
});

$app->run();
