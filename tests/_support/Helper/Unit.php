<?php

declare(strict_types=1);

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Unit extends Module
{
    public function getValidator(): ValidatorInterface
    {
        return $this->getModule('Symfony')->_getContainer()->get('validator');
    }
}
