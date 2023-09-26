<?php

declare(strict_types=1);

namespace App\Request\TestSession;

use App\Entity\Question\Question;
use App\Request\Question\AnswerVariantRequest;
use App\Request\Question\QuestionRequest;
use App\Validator\AnswerValidator;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Callback([AnswerValidator::class, 'validate'])]
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
