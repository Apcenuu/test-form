<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (ContainerConfigurator $containerConfigurator, FrameworkConfig $config): void {
    $config->validation()
        ->emailValidationMode('html5')
    ;

    if ($containerConfigurator->env() === 'test') {
        $config->validation()
            ->notCompromisedPassword()
            ->enabled(false)
        ;
    }
};
