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

use IMAG\PhdCallBundle\Form\Type\PhdType,
    IMAG\PhdCallBundle\Entity\Phd
    ;


/**
 * @Route("/phd")
 */
class PhdController extends Controller
{
    /**
     * @Route("", name="phd_index")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $phds = $this->getDoctrine()->getManager()
            ->getRepository("IMAGPhdCallBundle:Phd")
            ->getAll()
            ;

        return array(
            'phds' => $phds
        );
    }

    /**
     * @Route("/{id}", name="phd_show", requirements={"id" = "\d+"})
     * @Template()
     * @Method("GET")
     */
    public function showAction($id)
    {
        $phd = $this->getDoctrine()->getManager()
            ->getRepository("IMAGPhdCallBundle:Phd")
            ->getById($id)
            ;
        
        if (null === $phd) {
            throw $this->createNotFoundException("This phd doesn't exists");
        }

        return array(
            'phd' => $phd
        );
    }

    /**
     * @Route("/new", name="phd_new")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $form = $this->createForm(new PhdType());
        
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("", name="phd_create")
     * @Template("IMAGPhdCallBundle:Phd:new.html.twig")
     * @Method("POST")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form =  $this->createForm(new PhdType());
       
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('phd_show', array('id' => $form->getData()->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/edit", name="phd_edit", requirements={"id" = "\d+"})
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $phd = $this->getDoctrine()->getManager()
            ->getRepository("IMAGPhdCallBundle:Phd")
            ->getById($id)
            ;

        if (null === $phd) {
            throw $this->createNotFoundException("This phd doesn't exists");
        }

        $form = $this->createForm(new PhdType(), $phd);

        return  array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}", name="phd_update")
     * @Template("IMAGPhdCallBundle:Phd:edit.html.twig")
     * @Method("PUT")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(Request $request, $id)
    {
        /**
         * TODO : Check the authorization here too !
         */

        $em = $this->getDoctrine()->getManager();
        $phd = $em->getRepository('IMAGPhdCallBundle:Phd')
            ->getById($id);

        $form = $this->createForm(new PhdType(), $phd);
        
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($phd);
            $em->flush();
            
            return $this->redirect($this->generateUrl('phd_show', array('id' => $form->getData()->getId())));
        }
        
        return array(
            'form' => $form->createView()
        );
    }
}