<?php

namespace Model;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * StudentRepo
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepo extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $leftTeacherId
     * @param $rightTeacherId
     * @return QueryBuilder
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findIntersectsByTeachersIds($leftTeacherId, $rightTeacherId)
    {
        $query = $this->getEntityManager()->getConnection()->prepare('
        select s.*
        from teacher_student as ts
        inner join teacher_student as ts2
          on ts2.student_id = ts.student_id and ts2.teacher_id = :right_teacher_id
        inner join student as s on s.id = ts.student_id
        where ts.teacher_id = :left_teacher_id;');
        $query->bindValue('left_teacher_id', $leftTeacherId);
        $query->bindValue('right_teacher_id', $rightTeacherId);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
