<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\PhdRepository")
 * @ORM\Table(name="Phd")
 * @ORM\HasLifecycleCallbacks
 */
class Phd 
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
     * @Assert\NotBlank(message="Subject is required")
     */
    protected $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="Abstract mandatory")
     */
    protected $abstract;
    
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @Assert\File(maxSize="6000000")
     * @Assert\NotBlank(groups={"registration"})
     */
    protected $file;

    /**
     * @ORM\OneToMany(targetEntity="PhdUser", mappedBy="phd")
     * @Assert\Type("object")
     */
    protected $phdUsers;

    /**
     * @ORM\ManyToOne(targetEntity="PhdCategory", inversedBy="phds")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type("object")
     * @Assert\NotNull()
     */
    protected $category;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime('now');
        $this->phdUsers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set subject
     *
     * @param string $subject
     * @return Phd
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set abstract
     *
     * @param text $abstract
     * @return Phd
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * Get abstract
     *
     * @return text 
     */
    public function getAbstract()
    {
        return $this->abstract;
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
     * Get file
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set file
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return phd
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Add phdUser
     *
     * @param IMAG\PhdCallBundle\Entity\PhdUser $user
     * @return Phd
     */
    public function addPhdUser(\IMAG\PhdCallBundle\Entity\PhdUser $user)
    {
        $this->phdUsers[] = $user;
        return $this;
    }

    /**
     * Remove phdUser
     *
     * @param IMAG\PhdCallBundle\Entity\PhdUser $user
     */
    public function removePhdUser(\IMAG\PhdCallBundle\Entity\PhdUser $user)
    {
        $this->phdUsers->removeElement($user);
    }

    /**
     * Get phdUsers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhdUsers()
    {
        return $this->phdUsers;
    }

    /**
     * set category
     * 
     * @param IMAG\PhdCallBundle\Entity\PhdCategory $category
     * @return Phd
     */
    public function setCategory(\IMAG\PhdCallBundle\Entity\PhdCategory $category)
    {
        $this->category = $category;
        return $this;
    }
 
    /**
     * get category
     *
     * @return IMAG\PhdCallBundle\Entity\PhdCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * File Management
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/Phd';
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->path = uniqid().'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public static function determineValidationGroups(\Symfony\Component\Form\FormInterface $form)
    {
        return null === $form->getData()->getId() ? array('Default', 'registration') : array('Default');
    }

}