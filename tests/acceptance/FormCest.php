<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Entity\Question\Question;
use App\Tests\AcceptanceTester;

class FormCest
{
    public const URI         = '/test';
    public const FORM_CSS_ID = '#test_testQuestions_';

    public const ANSWERS_FIELD = '_concreteAnswers_';

    public const SELECTED_FIELD = '_selected';

    public const CORRECT_CSS_CLASS = '.test-question-correct';

    public const WRONG_CSS_CLASS = '.test-question-wrong';

    public const SUBMIT_BUTTON = 'button[type=submit]';

    public const COUNTER_CLASS = '.answer-counter';

    public const QUESTIONS_SELECTOR = '.alert-primary label.required';

    public function validationTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);
        $I->click(self::SUBMIT_BUTTON);

        $I->seeElement('.validation-errors');
    }

    public function successTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);

        $formQuestions = $I->grabMultiple(self::QUESTIONS_SELECTOR);

        foreach ($formQuestions as $formQuestion) {
            /** @var Question $question */
            $question = $I->grabRepository(Question::class)->findOneBy([
                'text' => $formQuestion,
            ]);
            foreach ($question->answerVariants as $variant) {
                if ($variant->correct) {
                    $I->checkOption(self::FORM_CSS_ID . $question->id . self::ANSWERS_FIELD . $variant->id . self::SELECTED_FIELD);
                    $I->seeCheckboxIsChecked(self::FORM_CSS_ID . $question->id . self::ANSWERS_FIELD . $variant->id . self::SELECTED_FIELD);
                }
            }
        }

        $I->click(self::SUBMIT_BUTTON);

        $I->seeNumberOfElements(self::CORRECT_CSS_CLASS, count($formQuestions));

        $I->canSee((string) count($formQuestions), self::COUNTER_CLASS);
    }

    public function successOneVariantTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);

        $formQuestions = $I->grabMultiple(self::QUESTIONS_SELECTOR);

        foreach ($formQuestions as $formQuestion) {
            /** @var Question $question */
            $question = $I->grabRepository(Question::class)->findOneBy([
                'text' => $formQuestion,
            ]);
            foreach ($question->answerVariants as $variant) {
                if ($variant->correct) {
                    $I->checkOption(self::FORM_CSS_ID . $question->id . self::ANSWERS_FIELD . $variant->id . self::SELECTED_FIELD);
                    $I->seeCheckboxIsChecked(self::FORM_CSS_ID . $question->id . self::ANSWERS_FIELD . $variant->id . self::SELECTED_FIELD);
                    break;
                }
            }
        }

        $I->click(self::SUBMIT_BUTTON);

        $I->seeNumberOfElements(self::CORRECT_CSS_CLASS, count($formQuestions));

        $I->canSee((string) count($formQuestions), self::COUNTER_CLASS);
    }

    public function selectAllTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);

        $formQuestions = $I->grabMultiple(self::QUESTIONS_SELECTOR);

        foreach ($formQuestions as $formQuestion) {
            /** @var Question $question */
            $question = $I->grabRepository(Question::class)->findOneBy([
                'text' => $formQuestion,
            ]);
            foreach ($question->answerVariants as $variant) {
                $I->checkOption(self::FORM_CSS_ID . $question->id . self::ANSWERS_FIELD . $variant->id . self::SELECTED_FIELD);
                $I->seeCheckboxIsChecked(self::FORM_CSS_ID . $question->id . self::ANSWERS_FIELD . $variant->id . self::SELECTED_FIELD);
            }
        }

        $I->click(self::SUBMIT_BUTTON);

        $I->seeNumberOfElements(self::WRONG_CSS_CLASS, count($formQuestions));

        $I->canSee('0', self::COUNTER_CLASS);
    }

}
