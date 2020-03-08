<?php

namespace EduBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Submission
 *
 * @ORM\Table(name="submission")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\SubmissionRepository")
 */
class Submission
{
    public static $languages = [
        45 => "Assembly (NASM 2.14.02)",
        46 => "Bash (5.0.0)",
        47 => "Basic (FBC 1.07.1)",
        48 => "C (GCC 7.4.0)",
        52 => "C++ (GCC 7.4.0)",
        49 => "C (GCC 8.3.0)",
        53 => "C++ (GCC 8.3.0)",
        50 => "C (GCC 9.2.0)",
        54 => "C++ (GCC 9.2.0)",
        51 => "C# (Mono 6.6.0.161)",
        55 => "Common Lisp (SBCL 2.0.0)",
        56 => "D (DMD 2.089.1)",
        57 => "Elixir (1.9.4)",
        58 => "Erlang (OTP 22.2)",
        44 => "Executable",
        59 => "Fortran (GFortran 9.2.0)",
        60 => "Go (1.13.5)",
        61 => "Haskell (GHC 8.8.1)",
        62 => "Java (OpenJDK 13.0.1)",
        63 => "JavaScript (Node.js 12.14.0)",
        64 => "Lua (5.3.5)",
        65 => "OCaml (4.09.0)",
        66 => "Octave (5.1.0)",
        67 => "Pascal (FPC 3.0.4)",
        68 => "PHP (7.4.1)",
        43 => "Plain Text",
        69 => "Prolog (GNU Prolog 1.4.5)",
        70 => "Python (2.7.17)",
        71 => "Python (3.8.1)",
        72 => "Ruby (2.7.0)",
        73 => "Rust (1.40.0)",
        74 => "TypeScript (3.7.4)",
    ];

    public static $statuses = [
        1 => "In Queue",
        2 => "Processing",
        3 => "Accepted",
        4 => "Wrong Answer",
        5 => "Time Limit Exceeded",
        6 => "Compilation Error",
        7 => "Runtime Error (SIGSEGV)",
        8 => "Runtime Error (SIGXFSZ)",
        9 => "Runtime Error (SIGFPE)",
        10 => "Runtime Error (SIGABRT)",
        11 => "Runtime Error (NZEC)",
        12 => "Runtime Error (Other)",
        13 => "Internal Error",
        14 => "Exec Format Error",
    ];

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
     * @ORM\ManyToOne(targetEntity="EduBoxBundle\Entity\Problem")
     */
    private $problem;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="EduBoxBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=64, nullable=true)
     */
    private $token;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var int
     * @ORM\Column(name="language_id", type="integer")
     */
    private $languageId;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=2048)
     */
    private $code;

    /**
     * @var int
     * @ORM\Column(name="last_status_id", type="integer", nullable=true)
     */
    private $lastStatusId;

    /**
     * @var ProblemTest
     * @ORM\ManyToOne(targetEntity="EduBoxBundle\Entity\ProblemTest")
     */
    private $nextTest;

    /**
     * @var
     * @ORM\Column(name="stdout", type="string", length=512, nullable=true)
     */
    private $stdout;

    /**
     * @var
     * @ORM\Column(name="stderr", type="string", length=512, nullable=true)
     */
    private $stderr;

    /**
     * @var
     * @ORM\Column(name="time", type="float", nullable=true)
     */
    private $time;

    /**
     * @var
     * @ORM\Column(name="memory", type="integer", nullable=true)
     */
    private $memory;



    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
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
     * Set problem
     *
     * @param Problem $problem
     *
     * @return Submission
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
     * Set user
     *
     * @param User $user
     *
     * @return Submission
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Submission
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $languageId
     * @return $this
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * @return mixed|null
     */
    public function getLanguageName()
    {
        return isset(self::$languages[$this->languageId])
            ? self::$languages[$this->languageId]
            : null;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $lastStatusId
     * @return $this
     */
    public function setLastStatusId($lastStatusId)
    {
        $this->lastStatusId = $lastStatusId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastStatusId()
    {
        return $this->lastStatusId;
    }

    /**
     * @return mixed|null
     */
    public function getLastStatusName()
    {
        if (isset(self::$statuses[$this->lastStatusId])) {
            return self::$statuses[$this->lastStatusId];
        }
        return null;
    }

    /**
     * @param $nextTest
     * @return $this
     */
    public function setNextTest($nextTest)
    {
        $this->nextTest = $nextTest;

        return $this;
    }

    /**
     * @return ProblemTest
     */
    public function getNextTest()
    {
        return $this->nextTest;
    }

    /**
     * @param $stdout
     * @return $this
     */
    public function setStdout($stdout)
    {
        $this->stdout = $stdout;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStdout()
    {
        return $this->stdout;
    }

    /**
     * @param $stderr
     * @return $this
     */
    public function setStderr($stderr)
    {
        $this->stderr = $stderr;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStderr()
    {
        return $this->stderr;
    }

    /**
     * @param $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param $memory
     * @return $this
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }
}

