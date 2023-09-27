<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
final class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @return iterable<Question>
     */
    public function allInRandomOrder(): iterable
    {
        $qb = $this->createQueryBuilder('q');

        /** @var Question[] $questions */
        $questions = $qb
            ->select('q')
            ->orderBy('random()')
            ->getQuery()
            ->getResult()
        ;

        return $questions;
    }
}
