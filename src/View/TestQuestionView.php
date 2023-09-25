<?php

declare(strict_types=1);

namespace App\View;

final readonly class TestQuestionView
{
    public QuestionView $question;

    /**
     * @var iterable<ConcreteAnswerView>
     */
    public iterable $concreteAnswers;

    /**
     * @param QuestionView $question
     * @param iterable<ConcreteAnswerView> $concreteAnswers
     */
    public function __construct(QuestionView $question, iterable $concreteAnswers)
    {
        $this->question = $question;
        $this->concreteAnswers = $concreteAnswers;
    }
}
