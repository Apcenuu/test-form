<?php

declare(strict_types=1);

use App\Doctrine\ColumnHydrator;

use App\Doctrine\Random;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $config): void {
    $dbal = $config->dbal()
        ->defaultConnection('default');

    $dbal->connection('default')
        ->url(env('DATABASE_URL'))
    ;

    $config->orm()
        ->autoGenerateProxyClasses(false)
        ->enableLazyGhostObjects(true)
        ->entityManager('default')
        ->autoMapping(true)
        ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware')
        ->mapping('App')
            ->isBundle(false)
            ->dir('%kernel.project_dir%/src/Entity')
            ->prefix('App\Entity')
            ->alias('App')
    ;

    $config->orm()
        ->entityManager('default')
        ->hydrator(ColumnHydrator::NAME, ColumnHydrator::class)
    ;

    $config->orm()
        ->entityManager('default')
        ->dql()
        ->numericFunction('random', Random::class)
    ;
};
