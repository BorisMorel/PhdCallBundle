<?php

namespace IMAG\PhdCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request
    ;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method
    ;

use IMAG\PhdCallBundle\Entity\PhdUser;

/**
 * @Route("/application")
 */
class ApplicationController extends Controller
{
    /**
     * @Route("/{id}", name="apply_new")
     * @Template()
     * @Method("GET")
     */
    public function newAction($id)
    {

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