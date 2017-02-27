# CSV Average Row Value Calculator

Simple app taking a csv with numerical values, calculating an average of all values per row
and appending that data to the row.  

### How to run

**Assuming you have docker-compose installed:**
```
docker-compose up -d
docker-compose exec php-fpm php bin/composer.phar install

browse to 127.0.0.1:9085
```

**If you run this locally:**
```
php bin/composer.phar install
php -S 127.0.0.1:9085

browse to 127.0.0.1:9085
```

#### Todo
 - add simple uploaded file validation (mime check?)
 - add CSRF token to the upload form
 - handle errors correctly
 - add tests
 
