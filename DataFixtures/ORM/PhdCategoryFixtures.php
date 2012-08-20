<?php

namespace IMAG\PhdCallBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface
    ;

use IMAG\PhdCallBundle\Entity\PhdCategory;

class PhdCategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat = new PhdCategory();
        $cat
            ->setName('Cat1')
            ;

        $manager->persist($cat);
        $manager->flush();

        $this->addReference('phdCategory1', $cat);         
    }

    public function getOrder()
    {
        return 2;
    }
}