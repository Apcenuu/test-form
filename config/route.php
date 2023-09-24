<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $configurator): void {

    if ('dev' !== $configurator->env()) {
        return;
    }

    $configurator->import('@FrameworkBundle/Resources/config/routing/errors.xml')
        ->prefix('/_error')
    ;
};
