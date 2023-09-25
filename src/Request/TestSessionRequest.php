<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\Question\Question;

final class TestSessionRequest
{
    /**
     * @param iterable<TestQuestionRequest> $testQuestions
     */
    public function __construct(public readonly iterable $testQuestions)
    {
    }

    /**
     * @param iterable<Question> $questions
     */
    public static function buildFromQuestions(iterable $questions): self
    {
        $testQuestionRequests = [];

        foreach ($questions as $question) {
            $testQuestionRequest = new TestQuestionRequest(new QuestionRequest($question));
            $concreteAnswers     = [];
            foreach ($question->answerVariants as $answerVariant) {
                $concreteAnswers[] = new ConcreteAnswerRequest(
                    false,
                    $testQuestionRequest,
                    new AnswerVariantRequest($answerVariant)
                );
            }
            $testQuestionRequest->concreteAnswers = $concreteAnswers;
            $testQuestionRequests[]               = $testQuestionRequest;
        }

        return new self($testQuestionRequests);
    }
}
