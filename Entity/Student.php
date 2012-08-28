<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Exception as Expt;

use IMAG\PhdCallBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\StudentRepository")
 * @ORM\Table(name="Student")
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
     * @ORM\Column(type="array")
     * @Assert\Type("array")
     * @Assert\NotNull()
     */
    protected $career;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="student")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type("object")
     * @Assert\NotNull
     */
    protected $user;

    public function __construct()
    {
        $this->career = array(
            array(),
        ); // To init one element for the display
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set career
     *
     * @param array $career
     * @return Application
     */
    public function setCareer(array $career)
    {
        $this->career = $career;

        return $this;
    }

    /**
     * Get career
     *
     * @return array 
     */
    public function getCareer()
    {
        return $this->career;
    }

    /**
     * Set user
     *
     * @param IMAG\PhdCallBundle\Entity\User $user
     * @return Student
     */
    public function setUser(\IMAG\PhdCallBundle\Entity\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return IMAG\PhdCallBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}