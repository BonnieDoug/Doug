<?php

namespace AppBundle\Entity;

/**
 * User: doug
 * Date: 4/24/17
 * Time: 11:39 PM
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="status")
 * @ORM\Entity()
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @ORM\Column(type="string", length=200) */
    private $name;

    /**
     * Status flag for Status.
     * The one place where retired is used instead of status, as really they can only be on/off and a join could cause issues long term.
     * @ORM\Column(type="boolean")
     */
    private $retired;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="status")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="status")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="status")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="status")
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Status
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set retired
     *
     * @param boolean $retired
     *
     * @return Status
     */
    public function setRetired($retired)
    {
        $this->retired = $retired;

        return $this;
    }

    /**
     * Get retired
     *
     * @return boolean
     */
    public function getRetired()
    {
        return $this->retired;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Status
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Status
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Comment $post
     *
     * @return Status
     */
    public function addPost(\AppBundle\Entity\Comment $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Comment $post
     */
    public function removePost(\AppBundle\Entity\Comment $post)
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
     * @param \AppBundle\Entity\Comment $image
     *
     * @return Status
     */
    public function addImage(\AppBundle\Entity\Comment $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Comment $image
     */
    public function removeImage(\AppBundle\Entity\Comment $image)
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
}
