<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

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

$fixtures = new Command('fixtures:load');
$fixtures->setDescription('Load data fixtures');
$fixtures->setCode(function (InputInterface $input, OutputInterface $output) use ($em) {
    $loader = new \Doctrine\Common\DataFixtures\Loader();
    $loader->loadFromFile(__DIR__.'/../src/fixtures.php');

    $purger   = new \Doctrine\Common\DataFixtures\Purger\ORMPurger();
    $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($em, $purger);
    $executor->execute($loader->getFixtures());
});

$commands[] = $fixtures;

$helperSet = ConsoleRunner::createHelperSet($em);
$helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'question');

return $helperSet;
