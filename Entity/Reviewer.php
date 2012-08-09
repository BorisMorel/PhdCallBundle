<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\ReviewerRepository")
 * @ORM\Table(name="Reviewer")
 * @ORM\HasLifecycleCallbacks
 */
class Reviewer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type("integer")
     */
    protected $id;

    
    
}