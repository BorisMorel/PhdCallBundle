<?php

namespace IMAG\PhdCallBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PhdRepository extends EntityRepository
{
    public function getById($id) 
    {
        $q = $this->createQueryBuilder('phd')
            ->select('phd')
            ->where('phd.id = ?1')
            ->setParameter(1, $id)
            ->getQuery();

        return $q->getSingleResult();
    }
}