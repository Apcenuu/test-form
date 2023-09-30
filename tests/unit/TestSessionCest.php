<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Question\AnswerVariant;
use App\Entity\Question\Question;
use App\Entity\TestSession\TestQuestion;
use App\Entity\TestSession\TestSession;
use App\Request\Question\AnswerVariantRequest;
use App\Request\Question\QuestionRequest;
use App\Request\TestSession\ConcreteAnswerRequest;
use App\Request\TestSession\TestQuestionRequest;
use App\Request\TestSession\TestSessionRequest;
use App\Tests\Helper\Unit;
use App\Tests\UnitTester;
use Doctrine\Common\Collections\ArrayCollection;

class TestSessionCest
{
    public function createTest(UnitTester $I): void
    {
        $testQuestions = [new TestQuestion(new Question('1+1', []), [])];
        $I->assertInstanceOf(TestSession::class, new TestSession($testQuestions));
    }

    public function buildFromRequestTest(UnitTester $I): void
    {
        $questions = [
            new Question('1+1', new ArrayCollection([
                new AnswerVariant('3', false),
                new AnswerVariant('2', true),
                new AnswerVariant('0', false),
            ])),
        ];
        $request = TestSessionRequest::buildFromQuestions($questions);
        $I->assertInstanceOf(TestSession::class, TestSession::fromRequest($request));
    }

    public function buildSessionRequestTest(UnitTester $I): void
    {
        $questions = [
            new Question('1+1', new ArrayCollection([
                new AnswerVariant('3', false),
                new AnswerVariant('2', true),
                new AnswerVariant('0', false),
            ])),
            new Question('2+2', new ArrayCollection([
                new AnswerVariant('4', true),
                new AnswerVariant('3+1', true),
                new AnswerVariant('10', false),
            ])),
            new Question('3+3', new ArrayCollection([
                new AnswerVariant('1+5', true),
                new AnswerVariant('1', false),
                new AnswerVariant('6', true),
                new AnswerVariant('2+4', true),
            ])),
        ];

        $request = TestSessionRequest::buildFromQuestions($questions);


        $I->assertInstanceOf(TestSessionRequest::class, $request);

        $questionKeys = array_keys($request->testQuestions);
        $I->assertEquals('1+1', $request->testQuestions[$questionKeys[0]]->questionRequest->question->text);
        $I->assertEquals('2+2', $request->testQuestions[$questionKeys[1]]->questionRequest->question->text);
        $I->assertEquals('3+3', $request->testQuestions[$questionKeys[2]]->questionRequest->question->text);
    }

    public function successValidationTest(UnitTester $I, Unit $helper): void
    {
        $answerVariant = new AnswerVariant('2', true);
        $question      = new Question('1+1', [$answerVariant]);

        $request                  = new TestQuestionRequest(new QuestionRequest($question));
        $request->concreteAnswers = [];

        $concreteAnswers = [
            new ConcreteAnswerRequest(
                true,
                $request,
                new AnswerVariantRequest($answerVariant)
            ),
        ];

        $request->concreteAnswers = $concreteAnswers;

        $errors = $helper->getValidator()->validate(new TestSessionRequest([$request]));

        $I->assertCount(0, $errors);
    }

    public function failedValidationTest(UnitTester $I, Unit $helper): void
    {
        $answerVariant = new AnswerVariant('2', true);
        $question      = new Question('1+1', [$answerVariant]);

        $request                  = new TestQuestionRequest(new QuestionRequest($question));
        $request->concreteAnswers = [];

        $concreteAnswers = [
            new ConcreteAnswerRequest(
                false,
                $request,
                new AnswerVariantRequest($answerVariant)
            ),
        ];

        $request->concreteAnswers = $concreteAnswers;

        $errors = $helper->getValidator()->validate(new TestSessionRequest([$request]));

        $I->assertCount(1, $errors);
    }
}
