<?php

namespace IMAG\PhdCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request
    ;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method
    ;

use JMS\SecurityExtraBundle\Annotation\Secure;

use IMAG\PhdCallBundle\Form\Type\StudentType,
    IMAG\PhdCallBundle\Entity\Student
    ;

/**
 * @Route("/user/student")
 */
class StudentController extends Controller
{
    /**
     * @Route("/new", name="student_new")
     * @Template()
     * @Method("GET")
     */
    public function newAction()
    {
        if (false !== $this->studentExists()) {
            return $this->redirect($this->generateUrl('student_edit'));
        }

        $form= $this->createForm(new StudentType(), new Student());

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("", name="student_create")
     * @Template("IMAGPhdCallBundle:Student:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        if (false !== $this->studentExists()) {
            return $this->redirect($this->generateUrl('student_edit'));
        }

        $student = new Student();
        $form = $this->createForm(new StudentType(), $student);
        $em = $this->getDoctrine()->getManager();

        $form->bind($request);

        if ($form->isValid()) {
            $student->setUser($this->getUser());
            $em->persist($student);
            $em->flush();
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit", name="student_edit")
     * @Template()
     * @Method("GET")
     */
    public function editAction()
    {
        $student = $this->studentExists();
            
        if (false === $student) {
            throw $this->createNotFoundException('You can edit a non created object');
        }
        
        $form = $this->createForm(new StudentType(), $student);

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("", name="student_update")
     * @Template("IMAGPhdCallBundle:Student:edit.html.twig")
     * @Method("PUT")
     */
    public function updateAction()
    {
        $student = $this->studentExists();

        if (false === $student) {
            throw $this->createNotFoundException('You can edit a non created object');
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new StudentType(), $student);

        if ($form->isValid()) {
            $em->persist($student);
            $em->flush();
        }
                
    }

    /**
     * Check if the student assoc already exists with a user
     *
     * @return mixed false|IMAG\PhdCallBundle\Entity\Student
     */

    private function studentExists() {
        
        $student = $this->getDoctrine()->getManager()
            ->getRepository('IMAGPhdCallBundle:Student')
            ->getByUser($this->getUser())
            ;

        return (null === $student) ? false : $student;
    }
}