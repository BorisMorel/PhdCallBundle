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
            ->setName('Physique')
            ;

        $manager->persist($cat);

        $cat1 = new PhdCategory();
        $cat1
            ->setName('Chimie')
            ;
        $manager->persist($cat1);

        $manager->flush();

        $this->addReference('Physique', $cat);
        $this->addReference('Chimie', $cat1);     
    }

    public function getOrder()
    {
        return 2;
    }
}