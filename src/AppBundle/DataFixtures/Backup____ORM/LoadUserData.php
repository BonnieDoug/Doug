<?php
/**
 * User: dhayward
 * Date: 25/04/17
 * Time: 16:51
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $statusReference = ['Active', 'Retired', 'Banned', 'In-Active'];

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('test@test.com');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($admin, 'password');
        $admin->setStatus($this->getReference("Active"));
        $admin->setPassword($password);
        $manager->persist($admin);
        $manager->flush();

        $batchSize = 20;
        for ($i = 1; $i <= 100; ++$i) {
            $randomStatus = array_rand($statusReference);
            $user = new User();
            $user->setUsername('User-' . $i);
            $user->setEmail("user-$i@email.com");
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user, 'password');
            $user->setStatus($this->getReference($statusReference[$randomStatus]));
            $user->setPassword($password);
            $manager->persist($user);
            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear(); // Detaches all objects from Doctrine!
            }
        }
        $manager->flush(); //Persist objects that did not make up an entire batch
        $manager->clear();

    }

    public function getOrder()
    {
        return 2;
    }

}