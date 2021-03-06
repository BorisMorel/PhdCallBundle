<?php

namespace IMAG\PhdCallBundle\Repository;

use Doctrine\ORM\EntityRepository;

use IMAG\PhdCallBundle\Entity\User;

class ApplicationRepository extends EntityRepository
{
    public function getByUser(User $user)
    {
        $q = $this->createQueryBuilder('a')
            ->select('a')
            ->join('a.phdUser', 'pu')
            ->join('pu.user', 'u')
            ->where('u.id = ?1')
            ->setParameter(1, $user->getId())
            ->getQuery()
            ;

        return $q->getResult();
    }

    public function getById($id)
    {
        $q = $this->createQueryBuilder('a')
            ->select('a','u', 'pu')
            ->join('a.phdUser', 'pu')
            ->join('pu.user', 'u')
            ->where('a.id = :appId')
            ->setParameter('appId', $id)
            ->getQuery()
            ;

        return $q->getOneOrNullResult();
    }
}