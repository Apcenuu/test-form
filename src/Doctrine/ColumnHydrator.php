<?php

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\ORM\Exception\MultipleSelectorsFoundException;
use Doctrine\ORM\Internal\Hydration\AbstractHydrator as Hydrator;
use Doctrine\ORM\Internal\Hydration\ArrayHydrator;
use RuntimeException;

final class ColumnHydrator extends Hydrator
{
    public const NAME = 'column_hydrator';

    /**
     * @throws MultipleSelectorsFoundException
     */
    protected function hydrateAllData(): array
    {
        /** @var array<string, string> $hints */
        $hints    = $this->_hints;
        $hydrator = new ArrayHydrator($this->_em);
        $result   = $hydrator->hydrateAll($this->statement(), $this->resultSetMapping(), $hints);

        if (count($result) > 1) {
            throw new RuntimeException('Allowed count row 1');
        }

        if (count($this->resultSetMapping()->fieldMappings) > 1) {
            throw MultipleSelectorsFoundException::create($this->resultSetMapping()->fieldMappings);
        }

        $value = current($result);

        return !is_array($value) ? [] : $value;
    }
}
