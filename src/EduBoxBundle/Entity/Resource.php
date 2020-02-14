<?php

namespace EduBoxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Resource
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\ResourceRepository")
 */
class Resource
{
    public static $context = 'resource';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     * @ORM\JoinTable(
     *     name="resource_category",
     *     joinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     *     }
     * )
     */
    private $categories;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag")
     * @ORM\JoinTable(
     *     name="resource_tag",
     *     joinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     *     }
     * )
     */
    private $tags;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="EduBoxBundle\Entity\Author", inversedBy="resources", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="resource_author",
     *     joinColumns={
     *          @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     *     }
     * )
     */
    private $authors;


    /**
     * Get id
     *
     * @return int
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
     * @return Resource
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
     * Set content
     *
     * @param string $content
     *
     * @return Resource
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set categories
     *
     * @param ArrayCollection $categories
     *
     * @return Resource
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set tags
     *
     * @param ArrayCollection $tags
     *
     * @return Resource
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set author
     *
     * @param ArrayCollection $authors
     *
     * @return Resource
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * Get author
     *
     * @return ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }
}

