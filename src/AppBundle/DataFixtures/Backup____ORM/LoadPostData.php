<?php
/**
 * Created by PhpStorm.
 * User: doug
 * Date: 4/26/17
 * Time: 1:40 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $statusReference = ['Active', 'Retired', 'Banned', 'In-Active'];
        $batchSize = 20;
        for ($i = 1; $i <= 100; ++$i) {
            $randomStatus = array_rand($statusReference);
            $post = new Post();
            $post->setTitle();
            $post->setBody();
            $post->setLikes();
            $post->setDislikes();
            $post->setStatus($this->getReference($statusReference[$randomStatus]));

            $manager->persist($post);
            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear(); // Detaches all objects from Doctrine!
            }
        }
        $manager->flush(); //Persist objects that did not make up an entire batch
        $manager->clear();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}