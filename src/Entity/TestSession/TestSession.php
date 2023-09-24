<?php

declare(strict_types=1);

namespace App\Entity\TestSession;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid as Uid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'test_session')]
class TestSession
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public Uid $id;

    /**
     * @var iterable<TestQuestion>
     */
    #[ORM\ManyToMany(targetEntity: TestQuestion::class, inversedBy: 'sessions', cascade: ['persist'])]
    public iterable $testQuestions;

    /**
     * @param iterable<TestQuestion> $testQuestions
     */
    public function __construct(iterable $testQuestions)
    {
        $this->id = Uuid::v6();

        $this->testQuestions = $testQuestions;
    }
}
