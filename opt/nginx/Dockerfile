FROM nginx:1.11

MAINTAINER Michal Zdrojewski <code@strayobject.co.uk>

COPY opt/nginx/nginx.conf /etc/nginx/nginx.conf
COPY opt/nginx/conf.d/upstream.conf /etc/nginx/conf.d/upstream.conf
COPY opt/nginx/sites/app.conf /etc/nginx/sites-available/app.conf

RUN mkdir /etc/nginx/sites-enabled && ln -s /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/app
RUN rm /etc/nginx/conf.d/default.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
