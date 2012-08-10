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
     * @ORM\OneToMany(targetEntity="PhdStudent", mappedBy="studentId")
     */
    protected $phdIds;

    public function __construct()
    {        
        $this->createdAt = $this->updatedAt = new \DateTime('now');
        $this->phdIds = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add phdIds
     *
     * @param IMAG\PhdCallBundle\Entity\PhdStudent $phdIds
     * @return Student
     */
    public function addPhdId(\IMAG\PhdCallBundle\Entity\PhdStudent $phdIds)
    {
        $this->phdIds[] = $phdIds;
        return $this;
    }

    /**
     * Remove phdIds
     *
     * @param IMAG\PhdCallBundle\Entity\PhdStudent $phdIds
     */
    public function removePhdId(\IMAG\PhdCallBundle\Entity\PhdStudent $phdIds)
    {
        $this->phdIds->removeElement($phdIds);
    }

    /**
     * Get phdIds
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhdIds()
    {
        return $this->phdIds;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

}