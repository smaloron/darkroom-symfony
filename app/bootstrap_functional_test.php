<?php
if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
    passthru(sprintf(
        'php "%s/console" cache:clear --env=%s --no-warmup',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));
}

require __DIR__ . '/bootstrap.php.cache';

//drop/create database
passthru(sprintf('php "%s/console" doctrine:database:drop --env=test --force', __DIR__)); // force used to avoid interaction

//create database
passthru(sprintf('php "%s/console" doctrine:database:create --env=test', __DIR__));

//init database
passthru(sprintf('php "%s/console" doctrine:schema:create --env=test', __DIR__));

// add custom initializations here, such as loading trigger, stored procedure or custom SQL

//insert fixtures
passthru(sprintf('php "%s/console" doctrine:fixtures:load --env=test -n', __DIR__)); // -n used to avoid interaction
