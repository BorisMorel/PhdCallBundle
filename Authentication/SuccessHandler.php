<?php

namespace IMAG\PhdCallBundle\Authentication;

use Symfony\Component\Security\Http\HttpUtils,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface,
    Symfony\Component\Security\Core\SecurityContextInterface
    ;

use Doctrine\ORM\EntityManager;

class SuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private 
        $httpUtils,
        $security,
        $em
        ;

    public function __construct(HttpUtils $httpUtils, SecurityContextInterface $security, EntityManager $em)
    {
        $this->httpUtils = $httpUtils;
        $this->security = $security;
        $this->em = $em;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        return $this->httpUtils->createRedirectResponse($request, $this->determinetargetUrl($request, $token));
    }

    private function determinetargetUrl(Request $request, TokenInterface $token)
    {
        if ($this->security->isGranted('ROLE_REVIEWER')) {
            if (null === $token->getUser()->getReviewer()) {
                $request->getSession()->getFlashBag()->add('notice', 'Please fill your profil information');
                return 'reviewer_new';
            } 
        } elseIf ($this->security->isGranted('ROLE_USER')) {
            if (null === $token->getUser()->getStudent()) {
                $request->getSession()->getFlashBag()->add('notice', 'Please fill your profil information');
                return 'student_new';
            }
        }              

        /**
         * TODO Inject the array options of form to get the parameters
         * _security.$id.target_path
         * option['login_path']
         */
        
        if ($target = $request->getSession()->get('_security.secured_area.target_path')) {
            return $target;
        }

        if (($target = $request->headers->get('Referer')) && ($target !== $this->httpUtils->generateUri($request, 'login'))) {
            return $target;
        }

        return '/';
        
    }
}