<?php

namespace IMAG\PhdCallBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface
    ;

use IMAG\PhdCallBundle\Entity\Phd;

class PhdFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $phd = new Phd();
        $phd
            ->setSubject('phd1')
            ->setAbstract('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend, leo sit amet rhoncus varius, felis augue sodales tortor, non suscipit nunc enim nec mi. Fusce varius, ligula in tincidunt fringilla, orci lectus gravida odio, a blandit mauris turpis a velit. Curabitur et felis dui. Ut consectetur rhoncus volutpat. Praesent at sem mi, sit amet lacinia mi. Donec sagittis felis eu justo elementum vehicula. Aliquam elementum lacus sed tortor mollis euismod. Cras tempor convallis tellus sed lobortis. Nulla massa leo, egestas eu vestibulum et, condimentum vel quam. Nullam diam augue, consequat quis molestie sollicitudin, eleifend non lorem. Nullam porttitor lorem eu risus eleifend sit amet consectetur tellus hendrerit. Cras cursus ullamcorper eros, vel venenatis turpis ornare a. Mauris elementum viverra est vel tristique. Nullam nunc turpis, imperdiet ac malesuada gravida, rutrum quis felis. Nulla at enim ut tellus venenatis porttitor. ')
            ->setCategory($manager->merge($this->getReference('Physique')))
            ;

        $manager->persist($phd);
        $manager->flush();

        $this->addReference('phd', $phd);
    }

    public function getOrder()
    {
        return 3;
    }
}