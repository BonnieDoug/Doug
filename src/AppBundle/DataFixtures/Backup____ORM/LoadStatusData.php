<?php
/**
 * Created by PhpStorm.
 * User: doug
 * Date: 4/26/17
 * Time: 1:40 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Status;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $active = new Status();
        $active->setName("Active");
        $active->setRetired(false);
        $manager->persist($active);
        $this->addReference('Active', $active);

        $retired = new Status();
        $retired->setName("Retired");
        $retired->setRetired(false);
        $manager->persist($retired);
        $this->addReference('Retired', $retired);


        $banned = new Status();
        $banned->setName("Banned");
        $banned->setRetired(false);

        $manager->persist($banned);
        $this->addReference('Banned', $banned);

        $inactive = new Status();
        $inactive->setName("In-Active");
        $inactive->setRetired(false);
        $manager->persist($inactive);
        $this->addReference('In-Active', $inactive);

        $manager->flush();

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}