<?php

declare(strict_types=1);

namespace App\Request;

final class TestQuestionRequest
{
    /**
     * @var  iterable<ConcreteAnswerRequest> $concreteAnswers
     */
    public iterable $concreteAnswers;


    public function __construct(
        public readonly QuestionRequest $questionRequest,
    ) {
    }
}
