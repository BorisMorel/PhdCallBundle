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
     * @Route("/new/phd/{phdId}", name="application_new")
     * @Template()
     * @Method("GET")
     */
    public function newAction($phdId)
    {
        $phd = $this->isReady($phdId);

        $form = $this->createForm(new ApplicationType(), new Application());
        
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/phd/{phdId}", name="application_create")
     * @Template("IMAGPhdCallBundle:Application:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request, $phdId)
    {
        $phd = $this->isReady($phdId);

        $phdUser = new PhdUser();
        $application = new Application();
        $form = $this->createForm(new ApplicationType(), $application);
        $em = $this->getDoctrine()->getManager();
        
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($application);
                       
            $phdUser
                ->setApplication($application) 
                ->setUser($this->getUser())
                ->setPhd($phd)
                ;
            $em->persist($phdUser);

            $em->flush();
            $this->redirect($this->generateUrl());
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Check many parts before trying to create a new application
     *
     * @param int phdId
     * @return \IMAG\PhdCallBundle\Entity\Phd
     */
    private function isReady($phdId)
    {
        $em = $this->getDoctrine()->getManager();
        $phd = $em->getRepository('IMAGPhdCallBundle:Phd')
            ->getById($phdId)
            ;
            
        if (null === $phd) {
            throw $this->createNotFoundException("This phd doesn't exists");
        }
        if ( null !== $em->getRepository('IMAGPhdCallBundle:PhdUser')
             ->userHavePhd($this->getUser(), $phd)) {
            throw $this->createNotFoundException('This application exists');
        }

        return $phd;     
    }
}