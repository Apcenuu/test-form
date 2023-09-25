<?php

declare(strict_types=1);

namespace App\View;


final readonly class TestSessionView
{
    /**
     * @var iterable<TestQuestionView>
     */
    public iterable $testQuestions;

    /**
     * @param iterable<TestQuestionView> $testQuestions
     */
    public function __construct(iterable $testQuestions)
    {
        $this->testQuestions = $testQuestions;
    }
}
