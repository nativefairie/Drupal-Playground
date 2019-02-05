# Drupal playground - setup using Docker

[![Build Status](https://travis-ci.org/wodby/docker4drupal.svg?branch=master)](https://travis-ci.org/wodby/docker4drupal)

## Codebase using composer - steps
1. Forked drupal-composer/drupal-project project from wodby
2. Downloaded and unpacked docker4drupal.tar.gz from wodby from the latest stable release to my project root
3. Deleted docker-compose.override.yml as it's used to deploy vanilla Drupal
4. Ensured APACHE_DOCUMENT_ROOT is correct, by default set to /var/www/html/web for composer-based projects where Drupal is in web subdirectory
Ensured database access settings in my settings.php corresponds to my values in .env file, e.g.:

```
$databases['default']['default'] = array (
  'database' => 'drupal', // same as $DB_NAME
  'username' => 'drupal', // same as $DB_USER
  'password' => 'drupal', // same as $DB_PASSWORD
  'host' => 'mariadb', // same as $DB_HOST
  'driver' => 'mysql',  // same as $DB_DRIVER
  'port' => '3306', // different for PostgreSQL
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql', // different for PostgreSQL
  'prefix' => '',
);
```

5. Configured domains e.g.:
> /etc/hosts 127.0.0.1 sandbox.dev.localhost
6. Uncommented lines in the compose file to run redis
7. Running containers: make up or docker-compose up -d
Your drupal website should be up and running at [http://sandbox.dev.localhost:81](http://sandbox.dev.localhost:81)
You can see status of your containers and their logs via portainer: [http://portainer.drupal.docker.localhost:8000](http://portainer.drupal.docker.localhost:8000)


