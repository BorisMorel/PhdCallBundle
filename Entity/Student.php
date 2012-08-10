<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\StudentRepository")
 * @UniqueEntity("email")
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\NotBlank(message="Lastname mandatory")
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\NotBlank(message="Firstname mandatory")
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank(message="Email required")
     */
    protected $email;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="Address mandatory")
     */
    protected $address;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type("numeric")
     * @Assert\NotBlank(message="ZipCode required")
     */
    protected $zip;
  
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotBlank(message="City required")
     */
    protected $city;

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
     * Set lastname
     *
     * @param string $lastname
     * @return Student
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Student
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param text $address
     * @return Student
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return text 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Student
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Student
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
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