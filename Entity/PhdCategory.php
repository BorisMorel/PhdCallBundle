<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\PhdCategoryRepository")
 */
class PhdCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type("integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\NotBlank(message="Category name is required")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("numeric")
     */
    protected $ordering;

    /**
     * @ORM\OneToMany(targetEntity="Phd", mappedBy="category")
     * @Assert\Type("object")
     */
    protected $phds;

    public function __construct()
    {
        $this->phds = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return PhdCategory
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return PhdCategory
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add phds
     *
     * @param IMAG\PhdCallBundle\Entity\Phd $phd
     * @return PhdCategory
     */
    public function addPhd(\IMAG\PhdCallBundle\Entity\Phd $phd)
    {
        $this->phds[] = $phd;
        return $this;
    }

    /**
     * Remove phds
     *
     * @param IMAG\PhdCallBundle\Entity\Phd $phd
     */
    public function removePhd(\IMAG\PhdCallBundle\Entity\Phd $phd)
    {
        $this->phds->removeElement($phd);
    }

    /**
     * Get phds
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhds()
    {
        return $this->phds;
    }

    public function __toString()
    {
        return $this->name;
    }
}