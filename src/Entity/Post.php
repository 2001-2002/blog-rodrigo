<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tittle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="postCollection")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="postCollection")
     */
    private $categoryCollection;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return mixed
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }



    /**
     * Post constructor.
     * @param $categoryCollection
     */
    public function __construct()
    {
        $this->categoryCollection = new ArrayCollection();
    }


    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategoryCollection()
    {
        return $this->categoryCollection;
    }

    /**
     * @param mixed $categoryCollection
     */
    public function setCategoryCollection($categoryCollection)
    {

        $this->categoryCollection = $categoryCollection;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTittle()
    {
        return $this->tittle;
    }

    public function setTittle($tittle)
    {
        $this->tittle = $tittle;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription( $description)
    {
        $this->description = $description;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function __toString()
    {
        return $this->tittle;
    }


}
