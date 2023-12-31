<?php

declare(strict_types=1);

namespace App\Request\Question;

use App\Entity\Question\AnswerVariant;

final class AnswerVariantRequest
{
    public function __construct(public readonly AnswerVariant $answerVariant)
    {
    }
}
