<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

/** @var \Doctrine\ORM\EntityManager $em */
$em = $app['orm.em'];

$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand();
$commands[] = new \Doctrine\DBAL\Migrations\Tools\Console\Command\UpToDateCommand();

$configuration = new \Doctrine\DBAL\Migrations\Configuration\Configuration($em->getConnection());
$configuration->setName('SturdyUmbrella Migrations');
$configuration->setMigrationsTableName('doctrine_migration_versions');
$configuration->setMigrationsDirectory(__DIR__.'/../src/migrations');
$configuration->setMigrationsNamespace('SturdyUmbrella\Migrations');

/** @var \Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand $command */
foreach ($commands as $command) {
    $command->setMigrationConfiguration($configuration);
}

$helperSet = ConsoleRunner::createHelperSet($em);
$helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'question');

return $helperSet;
