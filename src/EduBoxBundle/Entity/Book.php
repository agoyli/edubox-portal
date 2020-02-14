<?php

namespace EduBoxBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\BookRepository")
 */
class Book
{
    public static $context = 'book';
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
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="EduBoxBundle\Entity\Author", inversedBy="books", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="book_author",
     *     joinColumns={
     *          @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *     }
     * )
     */
    private $authors;

    /**
     * @var int
     *
     * @ORM\Column(name="page_count", type="integer", nullable=true)
     */
    private $pageCount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2048, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="date", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var Media|null
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    private $bookFile;

    /**
     * @var Media|null
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    private $bookImage;

    /**
     * @var integer
     * @ORM\Column(name="part", type="integer", nullable=true)
     */
    private $part;

    /**
     * @var integer
     * @ORM\Column(name="edition", type="integer", nullable=true)
     */
    private $edition;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="EduBoxBundle\Entity\Book")
     * @ORM\JoinTable(
     *     name="book_part",
     *     joinColumns={
     *          @ORM\JoinColumn(name="part_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *     }
     * )
     */
    private $parts;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="EduBoxBundle\Entity\Book")
     * @ORM\JoinTable(
     *     name="book_edition",
     *     joinColumns={
     *          @ORM\JoinColumn(name="edition_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *     }
     * )
     */
    private $editions;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     * @ORM\JoinTable(
     *     name="book_category",
     *     joinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *     }
     * )
     */
    private $categories;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag")
     * @ORM\JoinTable(
     *     name="book_tag",
     *     joinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *     }
     * )
     */
    private $tags;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->parts = new ArrayCollection();
        $this->editions = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

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
     * @return Book
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
     * Set author
     *
     * @param ArrayCollection $authors
     *
     * @return Book
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

    /**
     * Set pages
     *
     * @param integer $pageCount
     *
     * @return Book
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * Get pages
     *
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param integer $year
     *
     * @return Book
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Book
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
     * @param Media|null $bookFile
     */
    public function setBookFile(Media $bookFile = null)
    {
        $this->bookFile = $bookFile;
    }

    /**
     * @return Media|null
     */
    public function getBookFile()
    {
        return $this->bookFile;
    }

    /**
     * @param Media|null $bookImage
     */
    public function setBookImage(Media $bookImage = null)
    {
        $this->bookImage = $bookImage;
    }

    /**
     * @return Media|null
     */
    public function getBookImage()
    {
        return $this->bookImage;
    }


    /**
     * @param $part
     * @return $this
     */
    public function setPart($part)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * @return int
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * @param $edition
     * @return $this
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * @return int
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * @param $parts
     * @return $this
     */
    public function setParts($parts)
    {
        $this->parts = $parts;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * @param $editions
     * @return $this
     */
    public function setEditions($editions)
    {
        $this->editions = $editions;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEditions()
    {
        return $this->editions;
    }

    /**
     * @ORM\PrePersist
     */
    public function updatedTimestamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Set category
     *
     * @param ArrayCollection $categories
     *
     * @return Book
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get category
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
     * @return Book
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
     * @return string
     */
    public function __toString()
    {
        if ($this->name != '') return $this->name;
        return 'Book';
    }
}

