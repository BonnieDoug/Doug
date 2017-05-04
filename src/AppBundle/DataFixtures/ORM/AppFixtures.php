<?php

namespace AppBundle\DataFixtures\ORM;

///**
// * User: doug
// * Date: 4/26/17
// * Time: 2:08 PM
// */
//
//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;
//use Hautelook\AliceBundle\Alice\DataFixtureLoader;
//use Nelmio\Alice\Fixtures;
//
//class AppFixtures extends DataFixtureLoader {

//
//
//    /**
//     * {@inheritDoc}
//     */
//    public function load(ObjectManager $manager)
//    {
//        $objects = Fixtures::load(__DIR__ . '/Entity/status.yml', $manager);
//        $objects = Fixtures::load(__DIR__ . '/Entity/user.yml', $manager);
//        $objects = Fixtures::load(__DIR__ . '/Entity/category.yml', $manager);
//        $objects = Fixtures::load(__DIR__ . '/Entity/post.yml', $manager);
//
//    }
//}


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function encodepassword($plainPassword)
    {
        $user = new User();
        $encoder = $this->container->get('security.password_encoder');
        return $encoder->encodePassword($user, $plainPassword);

    }

    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__ . '/Entity/status.yml', $manager, ['providers' => [$this]]);
        $objects = Fixtures::load(__DIR__ . '/Entity/user.yml', $manager, ['providers' => [$this]]);
        $objects = Fixtures::load(__DIR__ . '/Entity/category.yml', $manager, ['providers' => [$this]]);
        $objects = Fixtures::load(__DIR__ . '/Entity/post.yml', $manager, ['providers' => [$this]]);
        $objects = Fixtures::load(__DIR__ . '/Entity/comment.yml', $manager, ['providers' => [$this]]);
    }
}