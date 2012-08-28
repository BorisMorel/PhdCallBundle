<?php

namespace IMAG\PhdCallBundle\Repository;

use Doctrine\ORM\EntityRepository;

use IMAG\PhdCallBundle\Entity\User;

class StudentRepository extends EntityRepository
{
    public function getByUser(User $user)
    {
        $q = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.id = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ;

        return $q->getOneOrNullResult();
    }
}