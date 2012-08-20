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
 * @Route("/apply")
 */
class ApplyController extends Controller
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

}