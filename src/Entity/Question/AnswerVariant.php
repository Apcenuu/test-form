<?php

declare(strict_types=1);

namespace App\Entity\Question;

use App\Entity\TestSession\ConcreteAnswer;
use App\Request\Question\AnswerVariantRequest;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid as Uid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'answer_variants')]
class AnswerVariant
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public Uid $id;

    #[ORM\Column(type: 'text')]
    public string $text;

    #[ORM\Column(type: 'boolean')]
    public bool $correct;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'answerVariants')]
    public Question $question;

    /**
     * @var iterable<ConcreteAnswer>
     */
    #[ORM\OneToMany(mappedBy: 'answerVariant', targetEntity: ConcreteAnswer::class)]
    public iterable $concreteAnswers;

    public function __construct(string $text, bool $correct)
    {
        $this->id      = Uuid::v6();
        $this->text    = $text;
        $this->correct = $correct;
    }

    public static function fromRequest(AnswerVariantRequest $answerVariant): self
    {
        return new self($answerVariant->answerVariant->text, $answerVariant->answerVariant->correct);
    }
}
