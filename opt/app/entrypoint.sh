#!/bin/bash

usermod -u 1000 www-data  && setfacl -R -m u:www-data:rwX /var/www/var && setfacl -dR -m u:www-data:rwX /var/www/var
