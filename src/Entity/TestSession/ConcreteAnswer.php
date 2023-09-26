<?php

declare(strict_types=1);

namespace App\Entity\TestSession;

use App\Entity\Question\AnswerVariant;
use App\Request\TestSession\ConcreteAnswerRequest;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid as Uid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'answer')]
class ConcreteAnswer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public Uid $id;

    #[ORM\Column(type: 'boolean')]
    public bool $selected;

    #[ORM\ManyToOne(targetEntity: AnswerVariant::class, inversedBy: 'concreteAnswers')]
    public AnswerVariant $answerVariant;

    #[ORM\ManyToOne(targetEntity: TestQuestion::class, inversedBy: 'concreteAnswers')]
    public TestQuestion $testQuestion;

    public function __construct(bool $selected, TestQuestion $testQuestion, AnswerVariant $answerVariant)
    {
        $this->id = Uuid::v6();

        $this->selected      = $selected;
        $this->testQuestion  = $testQuestion;
        $this->answerVariant = $answerVariant;
    }

    public static function fromRequest(ConcreteAnswerRequest $answerRequest, TestQuestion $testQuestion): self
    {
        return new self($answerRequest->selected, $testQuestion, $answerRequest->answerVariant->answerVariant);
    }
}
