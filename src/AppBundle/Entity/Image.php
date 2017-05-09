<?php

namespace AppBundle\Entity;

/**
 * User: doug
 * Date: 4/24/17
 * Time: 11:41 PM
 */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Image {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @ORM\Column(type="string", length=200) */
    private $name;

    /** @ORM\Column(type="string", length=200) */
    private $fileName;

    /** @ORM\Column(type="string", length=200) */
    private $urlSafeName;

    /** @ORM\Column(type="datetime", name="created_at") */
    private $createdAt;

    /** @ORM\Column(type="datetime", name="updated_at", nullable=true) */
    private $updatedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="images")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="images")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $post;

    /**
     * Status flag for Image.
     * Rather than a retired, locked, expired etc column, have put all in one and all tables can then share the same lookup table
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="images")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * Upvotes/Likes
     * @ORM\Column(type="integer", length=100)
     */
    private $likes;

    /**
     * Down-votes/DisLikes
     * @ORM\Column(type="integer", length=100)
     */
    private $dislikes;

    /**
     * Many Posts have Many Categories.
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="images")
     * @ORM\JoinTable(name="images_categories")
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct() {
        $this->categories = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Image
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Set urlSafeName
     *
     * @param string $urlSafeName
     *
     * @return Image
     */
    public function setUrlSafeName($urlSafeName) {
        $this->urlSafeName = $urlSafeName;

        return $this;
    }

    /**
     * Get urlSafeName
     *
     * @return string
     */
    public function getUrlSafeName() {
        return $this->urlSafeName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Image
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Image
     */
    public function setLikes($likes) {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes() {
        return $this->likes;
    }

    /**
     * Set dislikes
     *
     * @param integer $dislikes
     *
     * @return Image
     */
    public function setDislikes($dislikes) {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * Get dislikes
     *
     * @return integer
     */
    public function getDislikes() {
        return $this->dislikes;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Image
     */
    public function setUser(\AppBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return Image
     */
    public function setPost(\AppBundle\Entity\User $post = null) {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AppBundle\Entity\Post
     */
    public function getPost() {
        return $this->post;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return Image
     */
    public function setStatus(\AppBundle\Entity\Status $status = null) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Image
     */
    public function addCategory(\AppBundle\Entity\Category $category) {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category) {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Image
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
