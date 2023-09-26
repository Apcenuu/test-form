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

    public const RESULT_LINK = '.session-result a';

    public function validationTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);
        $I->click(self::SUBMIT_BUTTON);

        $I->seeElement('.validation-errors');
    }

    public function successTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);

        $questions = $I->grabRepository(Question::class)->findAll();

        foreach ($questions as $i => $question) {
            foreach ($question->answerVariants as $j => $answerVariant) {
                $I->seeNumberOfElements(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j, 1);
                if ($answerVariant->correct) {
                    $I->checkOption(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j . self::SELECTED_FIELD);
                    $I->seeCheckboxIsChecked(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j . self::SELECTED_FIELD);
                }
            }
        }

        $I->click(self::SUBMIT_BUTTON);
        $I->click(self::RESULT_LINK);

        $I->seeNumberOfElements(self::CORRECT_CSS_CLASS, count($questions));
    }

    public function successOneVariantTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);

        $questions = $I->grabRepository(Question::class)->findAll();

        foreach ($questions as $i => $question) {
            foreach ($question->answerVariants as $j => $answerVariant) {
                $I->seeNumberOfElements(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j, 1);
                if ($answerVariant->correct) {
                    $I->checkOption(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j . self::SELECTED_FIELD);
                    $I->seeCheckboxIsChecked(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j . self::SELECTED_FIELD);
                    break;
                }
            }
        }

        $I->click(self::SUBMIT_BUTTON);
        $I->click(self::RESULT_LINK);

        $I->seeNumberOfElements(self::CORRECT_CSS_CLASS, count($questions));
    }

    public function selectAllTest(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URI);

        $questions = $I->grabRepository(Question::class)->findAll();

        foreach ($questions as $i => $question) {
            foreach ($question->answerVariants as $j => $answerVariant) {
                $I->seeNumberOfElements(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j, 1);
                $I->checkOption(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j . self::SELECTED_FIELD);
                $I->seeCheckboxIsChecked(self::FORM_CSS_ID . $i . self::ANSWERS_FIELD . $j . self::SELECTED_FIELD);
            }
        }

        $I->click(self::SUBMIT_BUTTON);
        $I->click(self::RESULT_LINK);

        $I->seeNumberOfElements(self::WRONG_CSS_CLASS, count($questions));
    }

}
