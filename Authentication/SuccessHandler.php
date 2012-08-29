<?php

namespace IMAG\PhdCallBundle\Authentication;

use Symfony\Component\Security\Http\HttpUtils,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface
    ;

use Doctrine\ORM\EntityManager;

class SuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private 
        $httpUtils,
        $em
        ;

    public function __construct(HttpUtils $httpUtils, EntityManager $em)
    {
        $this->httpUtils = $httpUtils;
        $this->em = $em;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        return $this->httpUtils->createRedirectResponse($request, $this->determinetargetUrl($request, $token));
    }

    private function determinetargetUrl(Request $request, TokenInterface $token)
    {
        $student = $this->em->getRepository('IMAGPhdCallBundle:Student')
            ->getByUser($token->getuser())
            ;
        
        if (null === $student) {
            $request->getSession()->setFlash('notice', 'Please fill your profil information');
            return 'student_new';
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