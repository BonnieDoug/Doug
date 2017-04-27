<?php
/**
 * Created by PhpStorm.
 * User: doug
 * Date: 4/26/17
 * Time: 10:48 PM
 */

namespace AppBundle\DataFixtures\ORM;


use Nelmio\Alice\ProcessorInterface;
use AppBundle\Entity\User;

class UserProcessor implements ProcessorInterface
{
    protected $encoder;

    public function __construct($encoder)
    {
        $this->encoder = $encoder;
    }

    public function preProcess($object)
    {
        if (!$object instanceof User) {
            return;
        }
die("HERE");
        $password = $this->encoder->encodePassword($object, $object->getPassword());
        $object->setPassword($password);
    }

    public function postProcess($object)
    {

    }
}