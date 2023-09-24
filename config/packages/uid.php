<?php

declare(strict_types=1);


use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config): void {
    $config->uid()
      ->enabled(true)
       ->defaultUuidVersion(7)
       ->timeBasedUuidNode(7)
    ;
};
