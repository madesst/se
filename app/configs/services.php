<?php

namespace SE;

use Dbtlr\MigrationProvider\Provider\MigrationServiceProvider;
use Dezull\Silex\Provider\DBALPaginatorServiceProvider\DBALPaginatorServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Knp\Provider\ConsoleServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = Application::getInstance();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'locale' => 'en',
    'translator.domains' => array(),
));

$app->register(new DoctrineServiceProvider(), array(
    "db.options" => array(
        "driver"   => "pdo_mysql",
        'user'     => 'se',
        'dbname'   => 'se',
        'password' => '=.6q.q74_t7:%*7j_pC*m;%~58|B3*3N'
    )
));

$app->register(new DoctrineOrmServiceProvider(), array(
    "orm.em.options" => array(
        "mappings" => array(
            // Using actual filesystem paths
            array(
                "type"      => "yml",
                "namespace" => "Model",
                "path"      => __DIR__ . "/../../doctrine/mapping/"
            ),
        )
    )
));

$app->register(new ConsoleServiceProvider(), array(
        'console.name'              => 'MyConsoleApp',
        'console.version'           => '0.1.0',
        'console.project_directory' => __DIR__ . "/.."
    )
);

$app->register(new MigrationServiceProvider(), array(
    'db.migrations.path' => __DIR__ . '/../../doctrine/migrations',
));
$app->register(new DBALPaginatorServiceProvider(), array(
    'dezull.dbal_paginator.template.pagination' => 'Pagination/twitter_bootstrap_pagination.html.twig',
    'dezull.dbal_paginator.template.sortable' => 'Pagination/sortable_link.html.twig',
));

$app->register(new TwigServiceProvider(), array(
    'twig.path'    => [
        __DIR__ . '/../views',
        __DIR__.'/../../vendor/braincrafted/bootstrap-bundle/Braincrafted/Bundle/BootstrapBundle/Resources/views/Form',
        __DIR__.'/../../vendor/knplabs/knp-paginator-bundle/Knp/Bundle/PaginatorBundle/Resources/views',
    ],
    'twig.options' => array(
        'env' => ENVIRONMENT
    )
));
$app['twig'] = $app->share($app->extend('twig', function($twig) {
    $twig->addExtension(new \Braincrafted\Bundle\BootstrapBundle\Twig\BootstrapIconExtension);
    $twig->addExtension(new \Braincrafted\Bundle\BootstrapBundle\Twig\BootstrapLabelExtension);
    $twig->addExtension(new \Braincrafted\Bundle\BootstrapBundle\Twig\BootstrapBadgeExtension);
    $twig->addExtension(new \Braincrafted\Bundle\BootstrapBundle\Twig\BootstrapFormExtension);
    return $twig;
}));
$app->register(new ServiceControllerServiceProvider());

$app['teacher.ctr'] = $app->share(function () use ($app) {
    require_once __DIR__ . '/../controllers/TeacherController.php';

    return new TeacherController($app);
});
$app['student.ctr'] = $app->share(function () use ($app) {
    require_once __DIR__ . '/../controllers/StudentController.php';

    return new StudentController($app);
});
