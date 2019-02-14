#!/bin/bash
echo "This is an awesome build shell script"
cd ~/Sites/sandbox
if docker-compose ps | grep php
then
	docker-compose exec php bash
else docker-compose up -d && docker-compose exec php bash
fi

#Got to souce the build in the new shell
echo "Hello"
cd web
drush cex
../vendor/bin/drush site-install config_installer -y -r /var/www/html/web --site-name='SandBox' --site-mail=admin@example.com --account-mail=user@example.com --account-name='admin' --account-pass=admin
