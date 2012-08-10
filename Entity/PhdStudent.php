<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\PhdStudentRepository")
 * @ORM\Table(name="phd_student", uniqueConstraints={@ORM\UniqueConstraint(columns={"phd_id", "student_id"})})
 * @UniqueEntity({"phdId", "studentId"})
 * @ORM\HasLifecycleCallbacks
 */
class PhdStudent
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
     * @ORM\ManyToOne(targetEntity="Phd", inversedBy="studentIds")
     * @ORM\JoinColumn(name="phd_id", referencedColumnName="id", nullable=false)
     */
    protected $phdId;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="phdIds")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("object")
     */
    protected $studentId;

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
     * @return PhdStudent
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
     * Set studentId
     *
     * @param IMAG\PhdCallBundle\Entity\Student $studentId
     * @return PhdStudent
     */
    public function setStudentId(\IMAG\PhdCallBundle\Entity\Student $studentId)
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * Get studentId
     *
     * @return IMAG\PhdCallBundle\Entity\Student 
     */
    public function getStudentId()
    {
        return $this->studentId;
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