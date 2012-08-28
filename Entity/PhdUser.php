<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\PhdUserRepository")
 * @ORM\Table(name="phd_user", uniqueConstraints={@ORM\UniqueConstraint(columns={"phd_id", "user_id"})})
 * @UniqueEntity({"phd", "user"})
 * @ORM\HasLifecycleCallbacks
 */
class PhdUser
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type("integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotNull
     * @Assert\DateTime
     */
    protected $createdAt;
  
    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\NotNull
     * @Assert\DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Phd", inversedBy="phdUsers")
     * @ORM\JoinColumn(name="phd_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("object")
     */
    protected $phd;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="phdUsers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("object")
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="Application", mappedBy="phdUser")
     */
    protected $application;

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
     * Set phd
     *
     * @param IMAG\PhdCallBundle\Entity\Phd $phd
     * @return PhdUser
     */
    public function setPhd(\IMAG\PhdCallBundle\Entity\Phd $phd)
    {
        $this->phd = $phd;
        return $this;
    }

    /**
     * Get phd
     *
     * @return IMAG\PhdCallBundle\Entity\Phd 
     */
    public function getPhd()
    {
        return $this->phd;
    }

    /**
     * Set user
     *
     * @param IMAG\PhdCallBundle\Entity\User $user
     * @return PhdUser
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

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }


    /**
     * Set application
     *
     * @param IMAG\PhdCallBundle\Entity\Application $application
     * @return PhdUser
     */
    public function setApplication(\IMAG\PhdCallBundle\Entity\Application $application = null)
    {
        $this->application = $application;
        return $this;
    }

    /**
     * Get application
     *
     * @return IMAG\PhdCallBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }
}