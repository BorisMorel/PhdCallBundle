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

use IMAG\PhdCallBundle\Form\Type\UserType,
    IMAG\PhdCallBundle\Entity\User,
    IMAG\PhdCallBundle\Event\UserEvent
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
        if ($user = $this->processForm($request)) {
            $this->redirect($this->generateUrl('user_show', array('id' => $user->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/edit", name="user_edit")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $user = $this->getDoctrine()->getManager()
            ->getRepository("IMAGPhdCallBundle:User")
            ->getById($id)
            ;

        if (null === $user) {
            throw $this->createNotFoundException("This user doesn't exists");  
        }

        $form = $this->createForm(new UserType(), $user);

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}", name="user_update")
     * @Template("IMAGPhdCallBundle:User:edit.html.twig")
     * @Method("PUT")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(Request $request, $id)
    {
        if ($user = $this->processForm($request, $id)) {
            $this->redirect($this->generateUrl('user_show', array('id' => $user->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    private function processForm(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');

        if (null === $id) {
            $user = new User();
            $listener = 'CREATED';
        } else {
            $user = $this->getDoctrine()->getManager()
                ->getRepository("IMAGPhdCallBundle:User")
                ->getById($id)
                ;
            $listener = 'UPDATED';
        }

        $form = $this->createForm(new UserType(), $user);

        $form->bind($request);

        if ($form->isValid()) {
            $event = new UserEvent($user);
            $dispatcher->dispatch(constant("IMAG\PhdCallBundle\Event\PhdCallEvents::USER_{$listener}_PRE"), $event);
            
            $em->persist($user);
            $em->flush();

            $dispatcher->dispatch(constant("IMAG\PhdCallBundle\Event\PhdCallEvents::USER_{$listener}_POST"), $event);


            return $user;
        }

        return false;
    }
}