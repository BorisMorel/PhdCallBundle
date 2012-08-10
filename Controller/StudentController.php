<?php

namespace IMAG\PhdCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request
    ;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method
    ;

use IMAG\PhdCallBundle\Form\Type\StudentType,
    IMAG\PhdCallBundle\Entity\Student
    ;

/**
 * @Route("/student")
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
        $form = $this->createForm(new StudentType());
        
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/", name="student_create")
     * @Template("IMAGPhdCallBundle:Student:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form =  $this->createForm(new StudentType());
       
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('student_show', array('id' => $form->getData()->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }
    
}