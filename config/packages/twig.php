<?php

declare(strict_types=1);


use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\TwigConfig;

return static function (TwigConfig $config, ContainerConfigurator $configurator): void {
    $config->defaultPath('%kernel.project_dir%/templates');

    if ($configurator->env() !== 'test') {
        return;
    }

    $config->strictVariables(true);
};
