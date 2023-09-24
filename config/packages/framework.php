<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework, ContainerConfigurator $containerConfigurator): void {
    $framework
        ->secret(env('APP_SECRET'))
        ->httpMethodOverride(false)
        ->handleAllThrowables(true)

        ->profiler()
            ->onlyExceptions(false)
    ;

    $framework
        ->session()
            ->handlerId(null)
            ->cookieSecure('auto')
            ->cookieSamesite('lax')
            ->storageFactoryId('session.storage.factory.native')
    ;

    $framework
        ->phpErrors()
            ->log()
    ;

    if ('test' !== $containerConfigurator->env()) {
        return;
    }

    $framework->test(true)
        ->session()
        ->storageFactoryId('session.storage.factory.mock_file')
    ;
};
