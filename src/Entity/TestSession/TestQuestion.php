<?php

declare(strict_types=1);

namespace App\Entity\TestSession;

use App\Entity\Question\Question;
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

    public function __construct(Question $question)
    {
        $this->id       = Uuid::v6();
        $this->question = $question;
    }

    /**
     * @param iterable<ConcreteAnswer> $concreteAnswers
     */
    public function setConcreteAnswers(iterable $concreteAnswers): self
    {
        $this->concreteAnswers = $concreteAnswers;
        return $this;
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
