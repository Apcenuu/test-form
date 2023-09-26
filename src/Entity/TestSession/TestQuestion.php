<?php

declare(strict_types=1);

namespace App\Entity\TestSession;

use App\Entity\Question\Question;
use App\Request\TestSession\TestQuestionRequest;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid as Uid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'test_question')]
class TestQuestion
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public Uid $id;

    /**
     * @var iterable<TestSession>
     */
    #[ORM\ManyToMany(targetEntity: TestSession::class, mappedBy: 'testQuestions')]
    public iterable $sessions;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'testQuestions')]
    public Question $question;

    /**
     * @var iterable<ConcreteAnswer>
     */
    #[ORM\OneToMany(mappedBy: 'testQuestion', targetEntity: ConcreteAnswer::class, cascade: ['persist'])]
    public iterable $concreteAnswers;

    /**
     * @param iterable<ConcreteAnswer> $concreteAnswers
     */
    public function __construct(Question $question, iterable $concreteAnswers)
    {
        $this->id              = Uuid::v6();
        $this->question        = $question;
        $this->concreteAnswers = $concreteAnswers;
    }

    public static function fromRequest(TestQuestionRequest $testQuestionRequest): self
    {
        $concreteAnswers = [];

        $self = new self($testQuestionRequest->questionRequest->question, $concreteAnswers);

        foreach ($testQuestionRequest->concreteAnswers as $answer) {
            $concreteAnswers[] = ConcreteAnswer::fromRequest($answer, $self);
        }

        $self->concreteAnswers = $concreteAnswers;

        return $self;
    }

    public function isCorrectAnswered(): bool
    {
        $correctCount   = 0;
        $incorrectCount = 0;
        foreach ($this->concreteAnswers as $concreteAnswer) {
            if ($concreteAnswer->selected && !$concreteAnswer->answerVariant->correct) {
                $incorrectCount++;
            }
            if ($concreteAnswer->selected && $concreteAnswer->answerVariant->correct) {
                $correctCount++;
            }
        }

        return $incorrectCount == 0 && $correctCount > 0;
    }
}
