<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Question\AnswerVariant;
use App\Entity\Question\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Generator;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->dataProvider() as $question) {
            foreach ($question->answerVariants as $answer) {
                $answer->question = $question;
            }
            $manager->persist($question);
        }
        $manager->flush();
    }

    /**
     * @return Generator<Question>
     */
    private function dataProvider(): Generator
    {
        yield
            new Question('1+1', [
                new AnswerVariant('3', false),
                new AnswerVariant('2', true),
                new AnswerVariant('0', false),
            ])
        ;

        yield
            new Question('2+2', [
                new AnswerVariant('4', true),
                new AnswerVariant('3+1', true),
                new AnswerVariant('10', false),
            ])
        ;

        yield
            new Question('3+3', [
                new AnswerVariant('1+5', true),
                new AnswerVariant('1', false),
                new AnswerVariant('6', true),
                new AnswerVariant('2+4', true),
            ])
        ;

        yield
            new Question('4+4', [
                new AnswerVariant('8', true),
                new AnswerVariant('4', false),
                new AnswerVariant('0', false),
                new AnswerVariant('0+8', true),
            ])
        ;

        yield
            new Question('5+5', [
                new AnswerVariant('6', false),
                new AnswerVariant('18', false),
                new AnswerVariant('10', true),
                new AnswerVariant('9', false),
                new AnswerVariant('0', false),
            ])
        ;

        yield
            new Question('6+6', [
                new AnswerVariant('3', false),
                new AnswerVariant('9', false),
                new AnswerVariant('0', false),
                new AnswerVariant('12', true),
                new AnswerVariant('5+7', true),
            ])
        ;

        yield
            new Question('7+7', [
                new AnswerVariant('5', false),
                new AnswerVariant('14', true),
            ])
        ;

        yield
            new Question('8+8', [
                new AnswerVariant('16', true),
                new AnswerVariant('12', false),
                new AnswerVariant('9', false),
                new AnswerVariant('5', false),
            ])
        ;

        yield
            new Question('9+9', [
                new AnswerVariant('18', true),
                new AnswerVariant('9', false),
                new AnswerVariant('17+1', true),
                new AnswerVariant('2+16', true),
            ])
        ;

        yield
            new Question('10+10', [
                new AnswerVariant('0', false),
                new AnswerVariant('2', false),
                new AnswerVariant('8', false),
                new AnswerVariant('20', true),
            ])
        ;
    }
}
