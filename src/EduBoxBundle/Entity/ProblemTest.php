<?php

namespace EduBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProblemTest
 *
 * @ORM\Table(name="problem_test")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\ProblemTestRepository")
 */
class ProblemTest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Problem
     *
     * @ORM\ManyToOne(targetEntity="EduBoxBundle\Entity\Problem", inversedBy="tests")
     */
    private $problem;

    /**
     * @var string
     *
     * @ORM\Column(name="input", type="string", length=1024)
     */
    private $input;

    /**
     * @var string
     *
     * @ORM\Column(name="output", type="string", length=1024)
     */
    private $output;


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
     * Set problem
     *
     * @param Problem $problem
     *
     * @return ProblemTest
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem
     *
     * @return Problem
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * Set input
     *
     * @param string $input
     *
     * @return ProblemTest
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set output
     *
     * @param string $output
     *
     * @return ProblemTest
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Get output
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }
}

