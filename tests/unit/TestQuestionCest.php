<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Question\AnswerVariant;
use App\Entity\Question\Question;
use App\Entity\TestSession\ConcreteAnswer;
use App\Entity\TestSession\TestQuestion;
use App\Request\Question\AnswerVariantRequest;
use App\Request\Question\QuestionRequest;
use App\Request\TestSession\ConcreteAnswerRequest;
use App\Request\TestSession\TestQuestionRequest;
use App\Tests\UnitTester;

class TestQuestionCest
{
    public function buildTestQuestionTest(UnitTester $I): void
    {
        $answerVariant            = new AnswerVariant('2', true);
        $question                 = new Question('1+1', [$answerVariant]);
        $request                  = new TestQuestionRequest(new QuestionRequest($question));
        $request->concreteAnswers = [];
        $testQuestion             = TestQuestion::fromRequest($request);

        $I->assertInstanceOf(TestQuestion::class, $testQuestion);
    }

    public function isCorrectAnsweredTest(UnitTester $I): void
    {
        $answerVariant = new AnswerVariant('2', true);
        $question      = new Question('1+1', [$answerVariant]);

        $request                  = new TestQuestionRequest(new QuestionRequest($question));
        $request->concreteAnswers = [];

        $testQuestion = TestQuestion::fromRequest($request);

        $concreteAnswers = [ConcreteAnswer::fromRequest(
            new ConcreteAnswerRequest(
                true,
                $request,
                new AnswerVariantRequest($answerVariant)
            ),
            $testQuestion
        )];

        $testQuestion->concreteAnswers = $concreteAnswers;

        $I->assertTrue($testQuestion->isCorrectAnswered());
    }

    public function incorrectAnsweredTest(UnitTester $I): void
    {
        $answerVariant = new AnswerVariant('1', false);
        $question      = new Question('1+1', [$answerVariant]);

        $request                  = new TestQuestionRequest(new QuestionRequest($question));
        $request->concreteAnswers = [];

        $testQuestion = TestQuestion::fromRequest($request);

        $concreteAnswers = [ConcreteAnswer::fromRequest(
            new ConcreteAnswerRequest(
                true,
                $request,
                new AnswerVariantRequest($answerVariant)
            ),
            $testQuestion
        )];

        $testQuestion->concreteAnswers = $concreteAnswers;

        $I->assertFalse($testQuestion->isCorrectAnswered());
    }
}
