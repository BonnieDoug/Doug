<?php

namespace AppBundle\DataFixtures\ORM;

/**
 * User: doug
 * Date: 4/26/17
 * Time: 2:08 PM
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;

class AppFixtures extends DataFixtureLoader {
    public function encodepassword(User $user, $plainPassword)
    {
        /** @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder */
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__ . '/Entity/status.yml', $manager);
        $objects = Fixtures::load(__DIR__ . '/Entity/user.yml', $manager);
        $objects = Fixtures::load(__DIR__ . '/Entity/category.yml', $manager);
        $objects = Fixtures::load(__DIR__ . '/Entity/post.yml', $manager);

    }
}