<?php

namespace IMAG\PhdCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IMAG\PhdCallBundle\Repository\PhdStudentRepository")
 * @ORM\Table(name="phd_student")
 * @ORM\HasLifecycleCallbacks
 */
class PhdStudent
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Phd", inversedBy="studentIds")
     * @ORM\JoinColumn(name="phd_id", referencedColumnName="id")
     */
    protected $phdId;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="phdIds")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    protected $studentId;
}
