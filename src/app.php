<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app->register(new DoctrineServiceProvider(), [
    'db.options' => [
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__.'/../var/doctrine/app.db'
    ]
]);

$app->register(new DoctrineOrmServiceProvider(), [
    'orm.proxies_dir' => __DIR__.'/../var/doctrine',
    'orm.em.options'  => [
        'mappings' => [
            [
                'type'      => 'annotation',
                'namespace' => 'SturdyUmbrella\Entity',
                'path'      => __DIR__.'/Entity',
                'use_simple_annotation_reader' => false
            ]
        ]
    ]
]);

return $app;
