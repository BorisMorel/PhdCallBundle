<?php

namespace IMAG\PhdCallBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface
    ;

use IMAG\PhdCallBundle\Entity\User,
    IMAG\PhdCallBundle\Event\Entity\UserEvent,
    IMAG\PhdCallBundle\Event\PhdCallEvents
    ;

class UserFixtures extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private
        $container
        ;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        $user
            ->setLastname('Foo')
            ->setFirstname('Bob')
            ->setEmail('toto@imag.fr')
            ->setRoles(array('ROLE_USER', 'ROLE_REVIEWER', 'ROLE_ADMIN'))
            ->setAddress('toto')
            ->setCity('Gre')
            ->setZip('38000')
            ;

        $event = new UserEvent($user);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch(PhdCallEvents::USER_CREATED_PRE, $event);
        
        $manager->persist($user);
        $manager->flush();            

        $dispatcher->dispatch(PhdCallEvents::USER_CREATED_POST, $event);

        $this->addReference('user', $user);
    }

    public function getOrder()
    {
        return 1;
    }
}