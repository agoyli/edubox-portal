<?php

namespace EduBoxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Problem
 *
 * @ORM\Table(name="problem")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\ProblemRepository")
 */
class Problem
{
    public static $context = 'problem';
    const TIME_LIMIT = 5, MEMORY_LIMIT = 256;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EduBoxBundle\Entity\ProblemTest", mappedBy="problem", cascade={"persist"})
     */
    private $tests;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     * @ORM\JoinTable(
     *     name="problem_category",
     *     joinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     *     }
     * )
     */
    private $categories;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag")
     * @ORM\JoinTable(
     *     name="problem_tag",
     *     joinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     *     }
     * )
     */
    private $tags;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EduBoxBundle\Entity\ProblemCode", mappedBy="problem", cascade={"persist"})
     */
    private $codes;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->codes = new ArrayCollection();
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
     * @return Problem
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
     * Set description
     *
     * @param string $description
     *
     * @return Problem
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
     * Set categories
     *
     * @param ArrayCollection $categories
     *
     * @return Problem
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
     * @return Problem
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
     * @param $tests
     * @return $this
     */
    public function setTests($tests)
    {
        $this->tests = $tests;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTests()
    {
        return $this->tests;
    }

    public function addTest($test)
    {
        $this->tests->add($test);
    }

    /**
     * @param $codes
     * @return $this
     */
    public function setCodes($codes)
    {
        $this->codes = $codes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodes()
    {
        return $this->codes;
    }

    public function addCode($code)
    {
        $this->codes->add($code);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->getName() != '')
            return $this->getName();
        return 'Problem';
    }
}

