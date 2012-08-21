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
     * @Route("/{id}", name="application_new")
     * @Template()
     * @Method("GET")
     */
    public function newAction($id)
    {
        $form = $this->createForm(new ApplicationType());
        
        return array(
            'form' => $form->createView()
        );



        /*
          $em = $this->getDoctrine()->getManager();
          $user = $this->getUser();

          if (true === $this->isSubcribe($id)) {
          return $this->render('IMAGPhdCallBundle:Error:error.html.twig');
          }
        
          $phd = $this->getDoctrine()->getManager()
          ->getRepository('IMAGPhdCallBundle:Phd')
          ->getById($id)
          ;
        
          if (null === $phd) {
          throw $this->createNotFoundException("This phd doesn't exists");
          }

          $phdUser = new PhdUser();
          $phdUser->setUser($user);
          $phdUser->setPhd($phd);
          $em->persist($phdUser);
          $em->flush();   
        */
    }

    /**
     * @Route("/{id}", name="application_create")
     * @Template("IMAGPhdCallBundle:Application:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request, $id)
    {
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
                ->setPhd($em->getReference('IMAGPhdCallBundle:Phd', $id))
                ;
            $em->persist($phdUser);

            $em->flush();
            $this->redirect($this->generateUrl());
        }

        return array(
            'form' => $form->createView()
        );
    }

    private function isSubcribe($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
     
        if (null === $em->getRepository("IMAGPhdCallBundle:PhdUser")->userIdHavePhdId($user->getId(), $id)) {
            return false;
        }

        return true;     
    }

}