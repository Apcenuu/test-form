<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Question\AnswerVariant;
use App\Request\Question\AnswerVariantRequest;
use App\Tests\UnitTester;

class AnswerVariantCest
{
    public function buildFromRequestTest(UnitTester $I): void
    {
        $request = new AnswerVariantRequest(new AnswerVariant('3', false));

        $I->assertInstanceOf(AnswerVariant::class, AnswerVariant::fromRequest($request));
    }
}
