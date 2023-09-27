<?php

declare(strict_types=1);

namespace App\Entity\Question;

use App\Entity\TestSession\TestQuestion;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid as Uid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'questions')]
class Question
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public Uid $id;

    #[ORM\Column(type: 'text')]
    public string $text;

    /**
     * @var iterable<AnswerVariant>
     */
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: AnswerVariant::class, cascade: ['persist'])]
    public iterable $answerVariants;

    /**
     * @var iterable<TestQuestion>
     */
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: TestQuestion::class)]
    public iterable $testQuestions;

    /**
     * @param non-empty-string $text
     * @param iterable<AnswerVariant> $answerVariants
     */
    public function __construct(string $text, iterable $answerVariants)
    {
        $this->id             = Uuid::v6();
        $this->text           = $text;
        $this->answerVariants = $answerVariants;
    }
}
