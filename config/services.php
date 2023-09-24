<?php

declare(strict_types=1);


use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()

        ->load('App\\', '../src/')
            ->exclude([
                '../src/Entity/',
                '../src/Kernel.php',
            ])
    ;
};
