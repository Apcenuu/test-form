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

class ConcreteAnswerCest
{
    public function buildFromRequestTest(UnitTester $I): void
    {
        $answerVariant = new AnswerVariant('2', true);
        $question      = new Question('1+1', [$answerVariant]);
        $request       = new ConcreteAnswerRequest(
            false,
            new TestQuestionRequest(
                new QuestionRequest(
                    $question
                )
            ),
            new AnswerVariantRequest($answerVariant)
        );

        $entity = ConcreteAnswer::fromRequest($request, new TestQuestion(
            $question,
            [new ConcreteAnswer(false, new TestQuestion($question, []), $answerVariant)]
        ));

        $I->assertInstanceOf(ConcreteAnswer::class, $entity);
        $I->assertContainsOnlyInstancesOf(ConcreteAnswer::class, $entity->testQuestion->concreteAnswers);
    }
}
