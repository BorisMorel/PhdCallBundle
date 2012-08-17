<?php

namespace IMAG\PhdCallBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PhdRepository extends EntityRepository
{
    public function getById($id) 
    {
        $q = $this->createQueryBuilder('p')
            ->select('p', 'pc')
            ->join('p.category', 'pc')
            ->where('p.id = ?1')
            ->setParameter(1, $id)
            ->getQuery();

        return $q->getSingleResult();
    }
}