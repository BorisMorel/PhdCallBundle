<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\PhdUserRepository")
 * @ORM\Table(name="phd_user", uniqueConstraints={@ORM\UniqueConstraint(columns={"phd_id", "user_id"})})
 * @UniqueEntity({"phdId", "userId"})
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
     * @ORM\ManyToOne(targetEntity="Phd", inversedBy="userIds")
     * @ORM\JoinColumn(name="phd_id", referencedColumnName="id", nullable=false)
     */
    protected $phdId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="phdIds")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("object")
     */
    protected $userId;

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
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * Set phdId
     *
     * @param IMAG\PhdCallBundle\Entity\Phd $phdId
     * @return PhdUser
     */
    public function setPhdId(\IMAG\PhdCallBundle\Entity\Phd $phdId)
    {
        $this->phdId = $phdId;
        return $this;
    }

    /**
     * Get phdId
     *
     * @return IMAG\PhdCallBundle\Entity\Phd 
     */
    public function getPhdId()
    {
        return $this->phdId;
    }

    /**
     * Set userId
     *
     * @param IMAG\PhdCallBundle\Entity\User $userId
     * @return PhdUser
     */
    public function setUserId(\IMAG\PhdCallBundle\Entity\User $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get userId
     *
     * @return IMAG\PhdCallBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
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


}