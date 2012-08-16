<?php

namespace IMAG\PhdCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request
    ;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method
    ;

use IMAG\PhdCallBundle\Form\Type\UserType,
    IMAG\PhdCallBundle\Entity\User,
    IMAG\PhdCallBundle\Event\UserEvent,
    IMAG\PhdCallBundle\Event\PhdCallEvents
    ;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/new", name="user_new")
     * @Template()
     * @Method("GET")
     */
    public function newAction()
    {
        $form = $this->createForm(new UserType());
        
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/", name="user_create")
     * @Template("IMAGPhdCallBundle:User:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');
        $form =  $this->createForm(new UserType());
       
        $form->bind($request);

        if ($form->isValid()) {
            $event = new UserEvent($form->getData());
            $dispatcher->dispatch(PhdCallEvents::USER_PRE_REGISTER, $event);
            
            $em->persist($event->getUser());
            $em->flush();
           
            $dispatcher->dispatch(PhdCallEvents::USER_POST_REGISTER, $event);

            return $this->redirect($this->generateUrl('user_show', array('id' => $form->getData()->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }
    
}