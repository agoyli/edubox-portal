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
        1 => "Bash (4.4)",
        2 => "Bash (4.0)",
        3 => "Basic (fbc 1.05.0)",
        4 => "C (gcc 7.2.0)",
        5 => "C (gcc 6.4.0)",
        6 => "C (gcc 6.3.0)",
        7 => "C (gcc 5.4.0)",
        8 => "C (gcc 4.9.4)",
        9 => "C (gcc 4.8.5)",
        10 => "C++ (g++ 7.2.0)",
        11 => "C++ (g++ 6.4.0)",
        12 => "C++ (g++ 6.3.0)",
        13 => "C++ (g++ 5.4.0)",
        14 => "C++ (g++ 4.9.4)",
        15 => "C++ (g++ 4.8.5)",
        16 => "C# (mono 5.4.0.167)",
        17 => "C# (mono 5.2.0.224)",
        18 => "Clojure (1.8.0)",
        19 => "Crystal (0.23.1)",
        20 => "Elixir (1.5.1)",
        21 => "Erlang (OTP 20.0)",
        22 => "Go (1.9)",
        23 => "Haskell (ghc 8.2.1)",
        24 => "Haskell (ghc 8.0.2)",
        25 => "Insect (5.0.0)",
        26 => "Java (OpenJDK 9 with Eclipse OpenJ9)",
        27 => "Java (OpenJDK 8)",
        28 => "Java (OpenJDK 7)",
        29 => "JavaScript (nodejs 8.5.0)",
        30 => "JavaScript (nodejs 7.10.1)",
        31 => "OCaml (4.05.0)",
        32 => "Octave (4.2.0)",
        33 => "Pascal (fpc 3.0.0)",
        34 => "Python (3.6.0)",
        35 => "Python (3.5.3)",
        36 => "Python (2.7.9)",
        37 => "Python (2.6.9)",
        38 => "Ruby (2.4.0)",
        39 => "Ruby (2.3.3)",
        40 => "Ruby (2.2.6)",
        41 => "Ruby (2.1.9)",
        42 => "Rust (1.20.0)",
        43 => "Text (plain text)",
        44 => "Executable",
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

