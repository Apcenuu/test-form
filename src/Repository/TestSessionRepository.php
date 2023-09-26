<?php

declare(strict_types=1);

namespace App\Repository;

use App\Doctrine\ColumnHydrator;
use App\Entity\TestSession\TestSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestSession>
 */
final class TestSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestSession::class);
    }

    /**
     * This could have been calculated in TestQuestion::isCorrectAnswered, but I decided to write one SQL-query
     * @throws NonUniqueResultException
     */
    public function getCountRightAnswersBySession(TestSession $testSession): mixed
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count');

        $sql = <<<SQL
            SELECT count(questions.id) AS count FROM questions WHERE questions.id NOT IN (
                SELECT
                    q.id AS qstn
                FROM test_session

                JOIN test_session_test_question AS tstq ON test_session.id = tstq.test_session_id
                JOIN test_question AS tq ON tq.id = tstq.test_question_id
                JOIN questions AS q ON q.id = tq.question_id
                JOIN answer AS a ON tq.id = a.test_question_id
                JOIN answer_variants AS av ON a.answer_variant_id = av.id

                WHERE test_session.id = :test_session AND a.selected = true AND av.correct = false
            )
            SQL;

        $query = $this->_em->createNativeQuery($sql, $rsm)
            ->setParameters([
                'test_session' => $testSession->id,
            ])
            ->setHint('type', 'int')
        ;

        return $query->getOneOrNullResult(ColumnHydrator::NAME);
    }
}
