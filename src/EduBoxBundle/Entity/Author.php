<?php

namespace EduBoxBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Author
 *
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\AuthorRepository")
 */
class Author
{
    public static $context = 'author';
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
     * @ORM\Column(name="full_name", type="string", length=64)
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="EduBoxBundle\Entity\Book", mappedBy="authors")
     */
    private $books;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="EduBoxBundle\Entity\Resource", mappedBy="authors")
     */
    private $resources;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     * @ORM\JoinTable(
     *     name="author_category",
     *     joinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *     }
     * )
     */
    private $categories;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var Media|null
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    private $image;


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
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Author
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Author
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set categories
     *
     * @param ArrayCollection $categories
     *
     * @return Author
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
     * Set content
     *
     * @param string $content
     *
     * @return Author
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
     * @param Media|null $image
     */
    public function setImage(Media $image = null)
    {
        $this->image = $image;
    }

    /**
     * @return Media|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    public function __toString()
    {
        return isset($this->fullName) ? $this->fullName : 'Author';
    }
}

