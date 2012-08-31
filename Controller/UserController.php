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
    IMAG\PhdCallBundle\Form\Type\ReviewerRoleType,
    IMAG\PhdCallBundle\Entity\User,
    IMAG\PhdCallBundle\Event\Entity\UserEvent
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
     * @Route("", name="user_create")
     * @Template("IMAGPhdCallBundle:User:new.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new UserType());

        if ($this->processForm($request, $form)) {
            return $this->redirect($this->generateUrl('student_new'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/new/reviewer", name="user_role_reviewer")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function reviewerAction(Request $request)
    {
        $form = $this->createForm(new ReviewerRoleType());
        
        if ("POST" == $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $this->get('session')->set('RR', true);                    
                return $this->forward('IMAGPhdCallBundle:User:new');
            }
        }
        
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/edit", name="user_edit")
     * @Template()
     * @Method("GET")
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

        $form = $this->createForm(new UserType(), $user, array('allowedRolesChoices' => true));

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}", name="user_update")
     * @Template("IMAGPhdCallBundle:User:edit.html.twig")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getManager()
            ->getRepository("IMAGPhdCallBundle:User")
            ->getById($id)
            ;

        $form = $this->createForm(new UserType(), $user, array('allowedRolesChoices' => true));

        if ($this->processForm($request, $form)) {
            $this->redirect($this->generateUrl('apply', array('id' => $user->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    private function processForm(Request $request, \Symfony\Component\Form\Form $form)
    {
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');

        $form->bind($request);
        
        if ($form->isValid()) {
            
            $user = $form->getData();
            $listener = null === $user->getId() ? 'CREATED' : 'UPDATED';

            if (true === $this->get('session')->get('RR')) {
                $roles = $user->getRoles();
                array_push($roles, 'ROLE_REVIEWER');
                $user->setRoles($roles);
            }
        
            $event = new UserEvent($user);
            $dispatcher->dispatch(constant("IMAG\PhdCallBundle\Event\PhdCallEvents::USER_{$listener}_PRE"), $event);
            
            $em->persist($user);
            $em->flush();

            $dispatcher->dispatch(constant("IMAG\PhdCallBundle\Event\PhdCallEvents::USER_{$listener}_POST"), $event);
            return true;
        }
        
        return false;
    }
}