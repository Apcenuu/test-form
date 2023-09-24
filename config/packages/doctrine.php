<?php

declare(strict_types=1);

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


};
