<?php

namespace IMAG\PhdCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request
    ;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method
    ;

use IMAG\PhdCallBundle\Entity\PhdUser,
    IMAG\PhdCallBundle\Entity\Application,
    IMAG\PhdCallBundle\Form\Type\ApplicationType
    ;

/**
 * @Route("/application")
 */
class ApplicationController extends Controller
{
    
    /**
     * @Route("", name="application_index")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $applications = $this->getDoctrine()->getManager()
            ->getRepository("IMAGPhdCallBundle:Application")
            ->getByUser($this->getUser())
            ;

        return array(
            'applications' => $applications
        );
    }
    
    /**
     * @Route("/new/phd/{id}", name="application_new")
     * @Template()
     * @Method("GET")
     */
    public function newAction($id)
    {
        if (null === $this->getUser()->getStudent()) {
            $this->get('session')->getFlashBag()->add('notice', 'You need to fill your profil');
            return $this->redirect($this->generateUrl('student_new'));
        }

        $phd = $this->isReadyToNew($id);

        $form = $this->createForm(new ApplicationType());
        
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/phd/{id}", name="application_create")
     * @Template("IMAGPhdCallBundle:Application:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request, $id)
    {
        if (null === $this->getUser()->getStudent()) {
            $request->getSession()->getFlashBag()->add('notice', 'You need to fill your profil');
            return $this->redirect($this->generateUrl('student_new'));
        }

        $phd = $this->isReadyToNew($id);

        $phdUser = new PhdUser();
        $application = new Application();
        $form = $this->createForm(new ApplicationType(), $application);
        $em = $this->getDoctrine()->getManager();
        
        $form->bind($request);

        if ($form->isValid()) {
            $phdUser
                ->setUser($this->getUser())
                ->setPhd($phd)
                ;

            $em->persist($phdUser);

            $application->setPhdUser($phdUser);
            $em->persist($application);

            $em->flush();            

            return $this->redirect($this->generateUrl('application_edit', array('id' => $form->getData()->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/edit", name="application_edit")
     * @Template()
     * @Method("GET")
     */
    public function editAction($id)
    {
        $application = $this->isReadyToEdit($id);

        $form = $this->createForm(new ApplicationType(), $application);

        return array(
            'form' => $form->createView()
        );
    }

       /**
     * @Route("/{id}", name="application_update")
     * @Template("IMAGPhdCallBundle:Application:edit.html.twig")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $application = $this->isReadyToEdit($id);

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ApplicationType(), $application);
        
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($application);
            $em->flush();

            return $this->redirect($this->generateUrl('application_edit', array('id' => $application->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Check many parts before trying to create a new application
     *
     * @param int id
     * @return IMAG\PhdCallBundle\Entity\Phd
     */
    private function isReadyToNew($id)
    {
        $em = $this->getDoctrine()->getManager();
        $phd = $em->getRepository('IMAGPhdCallBundle:Phd')
            ->getById($id)
            ;
            
        if (null === $phd) {
            throw $this->createNotFoundException("This phd doesn't exists");
        }
        if (null !== $em->getRepository('IMAGPhdCallBundle:PhdUser')
            ->userHavePhd($this->getUser(), $phd)) {
            throw $this->createNotFoundException('This application exists');
        }
     
        return $phd;     
    }

    /**
     * Check many parts before trying to edit an application
     *
     * @param int id
     * @return IMAG\PhdCallBundle\Entity\Application
     */
    private function isReadyToEdit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $application = $em->getRepository('IMAGPhdCallBundle:Application')
            ->getById($id)
            ;

        if (null === $application) {
            throw $this->createNotFoundException("This application doesn't exists");
        }
        if ($this->getUser() !== $application->getPhdUser()->getUser()) {
            throw $this->createNotFoundException("Please edit only YOUR application");
        }

        return $application;
    }
}