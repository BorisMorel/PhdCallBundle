<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Exception as Expt;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\User\EquatableInterface
    ;

use IMAG\PhdCallBundle\Util\Security;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @ORM\Table(name="User")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, EquatableInterface, \Serializable
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
     * @ORM\Column(type="string", length=255)
     * @Assert\type("string")
     * @Assert\NotBlank()
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    protected $password;

    /**
     * @Assert\Type("string")
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="array")
     * @Assert\Type("array")
     * @Assert\NotBlank()
     */
    protected $roles;

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
     * @ORM\OneToMany(targetEntity="PhdUser", mappedBy="user")
     */
    protected $phdUsers;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="user")
     */
    protected $student;
    
    public function __construct()
    {
        $this->plainPassword = Security::randomPassword();
        $this->salt = uniqid(mt_rand(), true);
        $this->createdAt = $this->updatedAt = new \DateTime('now');
        $this->phdUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array("ROLE_USER");
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
     * Get username used by UserInterface
     *
     * @return string email
     */
    public function getUsername()
    {
        return $this->getEmail();
    }


    /**
     * EraseCredentials used by UserInterface.
     */
    public function eraseCredentials()
    {
        $this->password = null;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
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
     * @return User
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
     * @return User
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
     * Set salt
     *
     * @return Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function setSalt()
    {
        return new Expt\AccessDeniedException("Salt can be setted only by User::__construct()");
    }

    /**
     * Get salt used by UserInterface.
     *
     * @return string salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the hashed password
     * 
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set plain-text password
     *
     * @return Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function setPlainPassword()
    {
        return new Expt\AccessDeniedException("Plain-text password can be setted only by User::__construct()");
    }

    /**
     * Get plain-text password
     *
     * @return string plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set Roles
     *
     * @param array roles
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set address
     *
     * @param text $address
     * @return User
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
     * @return User
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
     * @return User
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
     * Add phdUser
     *
     * @param IMAG\PhdCallBundle\Entity\PhdUser $phd
     * @return User
     */
    public function addPhdUser(\IMAG\PhdCallBundle\Entity\PhdUser $phd)
    {
        $this->phdUsers[] = $phd;
        return $this;
    }

    /**
     * Remove phdUser
     *
     * @param IMAG\PhdCallBundle\Entity\PhdUser $phd
     */
    public function removePhdUser(\IMAG\PhdCallBundle\Entity\PhdUser $phd)
    {
        $this->phdUsers->removeElement($phd);
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
     * Test if $user is equal whit self::User()
     *
     * return boolean
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceOf User
            || $user->id !== $this->id
            || $user->lastname !== $this->lastname
            || $user->firstname !== $this->firstname
            || $user->email !== $this->email
            || count(array_diff($user->getRoles(), $this->roles)) > 0
            || $user->address !== $this->address
            || $user->zip !== $this->zip
            || $user->city !== $this->city
        ) {
            return false;
        }

        return true;
    }

    /**
     * serialize used by \Serializable
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->lastname,
            $this->firstname,
            $this->email,
            $this->roles,
            $this->address,
            $this->zip,
            $this->city
        ));
    }
    
    /**
     * unserialize used by \Serializable
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->lastname,
            $this->firstname,
            $this->email,
            $this->roles,
            $this->address,
            $this->zip,
            $this->city  
        ) = unserialize($serialized);
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

}