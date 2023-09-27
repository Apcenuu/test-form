<?php

declare(strict_types=1);

namespace App\Validator;

use App\Request\TestSession\ConcreteAnswerRequest;
use App\Request\TestSession\TestSessionRequest;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class AnswerValidator
{
    public static function validate(TestSessionRequest $testSession, ExecutionContextInterface $context): void
    {
        foreach ($testSession->testQuestions as $testQuestion) {
            $selectedAnswers = array_filter((array) $testQuestion->concreteAnswers, function (ConcreteAnswerRequest $answer) {
                return $answer->selected;
            });
            if (count($selectedAnswers) == 0) {
                $context->buildViolation('You forgot question ' . $testQuestion->questionRequest->question->text)
                    ->addViolation()
                ;
            }
        }
    }
}
