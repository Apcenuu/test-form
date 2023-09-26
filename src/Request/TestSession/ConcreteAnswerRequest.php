<?php

declare(strict_types=1);

namespace App\Request\TestSession;

use App\Request\Question\AnswerVariantRequest;

final class ConcreteAnswerRequest
{
    public bool $selected;

    public function __construct(
        bool $selected,
        public TestQuestionRequest $testQuestion,
        public readonly AnswerVariantRequest $answerVariant
    ) {
        $this->selected = $selected;
    }
}
