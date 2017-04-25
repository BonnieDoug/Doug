<?php

namespace AppBundle\Entity;

/**
 * User: doug
 * Date: 4/24/17
 * Time: 11:37 PM
 */

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="user")
     */
    private $images;

    /**
     * Status flag for User.
     * Rather than a retired, locked, expired etc column, have put all in one and all tables can then share the same lookup table
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="users")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;


    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="userFriends")
     */
    private $friendsWithUser;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithUser")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
     */
    private $userFriends;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->friendsWithUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userFriends = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return User
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return User
     */
    public function setStatus(\AppBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add friendsWithUser
     *
     * @param \AppBundle\Entity\User $friendsWithUser
     *
     * @return User
     */
    public function addFriendsWithUser(\AppBundle\Entity\User $friendsWithUser)
    {
        $this->friendsWithUser[] = $friendsWithUser;

        return $this;
    }

    /**
     * Remove friendsWithUser
     *
     * @param \AppBundle\Entity\User $friendsWithUser
     */
    public function removeFriendsWithUser(\AppBundle\Entity\User $friendsWithUser)
    {
        $this->friendsWithUser->removeElement($friendsWithUser);
    }

    /**
     * Get friendsWithUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithUser()
    {
        return $this->friendsWithUser;
    }

    /**
     * Add userFriend
     *
     * @param \AppBundle\Entity\User $userFriend
     *
     * @return User
     */
    public function addUserFriend(\AppBundle\Entity\User $userFriend)
    {
        $this->userFriends[] = $userFriend;

        return $this;
    }

    /**
     * Remove userFriend
     *
     * @param \AppBundle\Entity\User $userFriend
     */
    public function removeUserFriend(\AppBundle\Entity\User $userFriend)
    {
        $this->userFriends->removeElement($userFriend);
    }

    /**
     * Get userFriends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserFriends()
    {
        return $this->userFriends;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(
            array(
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt,
            )
        );
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function getSalt()
    {
        return false;
    }

}
