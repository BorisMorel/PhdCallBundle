<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Exception as Expt;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\ApplicationRepository")
 * @ORM\Table(name="Application")
 * @ORM\HasLifecycleCallbacks
 */
class Application
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type("integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="Your motivation arguments are required")
     */
    protected $motivation;
  
    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     * @Assert\NotNull()
     */
    protected $isConfirmed;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    protected $createdAt;
  
    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    protected $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="PhdUser", inversedBy="application")
     * @ORM\JoinColumn(name="phd_user_id", nullable=false)
     * @Assert\Type("object")
     */
    protected $phdUser;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime('now');
        $this->isConfirmed = false;
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
     * Set motivation
     *
     * @param text $motivation
     * @return Application
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    /**
     * Get motivation
     *
     * @return text 
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set isConfirmed
     *
     * @param boolean $isConfirmed
     * @return Application
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * Get isConfirmed
     *
     * @return boolean 
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     * @return Application
     */
    public function setCreatedAt($createdAt)
    {
        return new Expt\AccessDeniedException("Creation date can be setted only by self::");
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     * @return Application
     */
    public function setUpdatedAt($updatedAt)
    {
        return new Expt\AccessDeniedException("Modification date can be setted only by self::");
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set phdUser
     *
     * @param IMAG\PhdCallBundle\Entity\PhdUser $phdUser
     * @return Application
     */
    public function setPhdUser(\IMAG\PhdCallBundle\Entity\PhdUser $phdUser)
    {
        $this->phdUser = $phdUser;
        return $this;
    }

    /**
     * Get phdUser
     *
     * @return IMAG\PhdCallBundle\Entity\PhdUser 
     */
    public function getPhdUser()
    {
        return $this->phdUser;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

}