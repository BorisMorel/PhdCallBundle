<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\StudentRepository")
 * @ORM\Table(name="Student")
 * @ORM\HasLifecycleCallbacks
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type("integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="PhdStudent", mappedBy="studentId")
     */
    protected $phdIds;

    public function __construct()
    {
        $this->phdIds = new \Doctrine\Common\Collections\ArrayCollection();
    }
}