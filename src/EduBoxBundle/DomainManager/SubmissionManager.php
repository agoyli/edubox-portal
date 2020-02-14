<?php


namespace EduBoxBundle\DomainManager;


use Cassandra\Time;
use Doctrine\ORM\EntityManagerInterface;
use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\ProblemTest;
use EduBoxBundle\Entity\Submission;
use EduBoxBundle\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubmissionManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getObject($submissionId = null)
    {
        if ($submissionId > 0) {
            $submission = $this->entityManager
                ->getRepository('EduBoxBundle:Submission')
                ->find($submissionId);
            if ($submission instanceof Submission)
                return $submission;
        }
        return null;
    }

    public function getHost()
    {
        return 'https://api.judge0.com';
    }

    public function getLanguages()
    {
        /*return json_decode(
            '[{"id":1,"name":"Bash (4.4)"},{"id":2,"name":"Bash (4.0)"},{"id":3,"name":"Basic (fbc 1.05.0)"},{"id":4,"name":"C (gcc 7.2.0)"},{"id":5,"name":"C (gcc 6.4.0)"},{"id":6,"name":"C (gcc 6.3.0)"},{"id":7,"name":"C (gcc 5.4.0)"},{"id":8,"name":"C (gcc 4.9.4)"},{"id":9,"name":"C (gcc 4.8.5)"},{"id":10,"name":"C++ (g++ 7.2.0)"},{"id":11,"name":"C++ (g++ 6.4.0)"},{"id":12,"name":"C++ (g++ 6.3.0)"},{"id":13,"name":"C++ (g++ 5.4.0)"},{"id":14,"name":"C++ (g++ 4.9.4)"},{"id":15,"name":"C++ (g++ 4.8.5)"},{"id":16,"name":"C# (mono 5.4.0.167)"},{"id":17,"name":"C# (mono 5.2.0.224)"},{"id":18,"name":"Clojure (1.8.0)"},{"id":19,"name":"Crystal (0.23.1)"},{"id":20,"name":"Elixir (1.5.1)"},{"id":21,"name":"Erlang (OTP 20.0)"},{"id":22,"name":"Go (1.9)"},{"id":23,"name":"Haskell (ghc 8.2.1)"},{"id":24,"name":"Haskell (ghc 8.0.2)"},{"id":25,"name":"Insect (5.0.0)"},{"id":26,"name":"Java (OpenJDK 9 with Eclipse OpenJ9)"},{"id":27,"name":"Java (OpenJDK 8)"},{"id":28,"name":"Java (OpenJDK 7)"},{"id":29,"name":"JavaScript (nodejs 8.5.0)"},{"id":30,"name":"JavaScript (nodejs 7.10.1)"},{"id":31,"name":"OCaml (4.05.0)"},{"id":32,"name":"Octave (4.2.0)"},{"id":33,"name":"Pascal (fpc 3.0.0)"},{"id":34,"name":"Python (3.6.0)"},{"id":35,"name":"Python (3.5.3)"},{"id":36,"name":"Python (2.7.9)"},{"id":37,"name":"Python (2.6.9)"},{"id":38,"name":"Ruby (2.4.0)"},{"id":39,"name":"Ruby (2.3.3)"},{"id":40,"name":"Ruby (2.2.6)"},{"id":41,"name":"Ruby (2.1.9)"},{"id":42,"name":"Rust (1.20.0)"},{"id":43,"name":"Text (plain text)"},{"id":44,"name":"Executable"}]'
        );*/
        return json_decode(
            '[{"id":45,"name":"Assembly (NASM 2.14.02)"},{"id":46,"name":"Bash (5.0.0)"},{"id":47,"name":"Basic (FBC 1.07.1)"},{"id":48,"name":"C (GCC 7.4.0)"},{"id":52,"name":"C++ (GCC 7.4.0)"},{"id":49,"name":"C (GCC 8.3.0)"},{"id":53,"name":"C++ (GCC 8.3.0)"},{"id":50,"name":"C (GCC 9.2.0)"},{"id":54,"name":"C++ (GCC 9.2.0)"},{"id":51,"name":"C# (Mono 6.6.0.161)"},{"id":55,"name":"Common Lisp (SBCL 2.0.0)"},{"id":56,"name":"D (DMD 2.089.1)"},{"id":57,"name":"Elixir (1.9.4)"},{"id":58,"name":"Erlang (OTP 22.2)"},{"id":44,"name":"Executable"},{"id":59,"name":"Fortran (GFortran 9.2.0)"},{"id":60,"name":"Go (1.13.5)"},{"id":61,"name":"Haskell (GHC 8.8.1)"},{"id":62,"name":"Java (OpenJDK 13.0.1)"},{"id":63,"name":"JavaScript (Node.js 12.14.0)"},{"id":64,"name":"Lua (5.3.5)"},{"id":65,"name":"OCaml (4.09.0)"},{"id":66,"name":"Octave (5.1.0)"},{"id":67,"name":"Pascal (FPC 3.0.4)"},{"id":68,"name":"PHP (7.4.1)"},{"id":43,"name":"Plain Text"},{"id":69,"name":"Prolog (GNU Prolog 1.4.5)"},{"id":70,"name":"Python (2.7.17)"},{"id":71,"name":"Python (3.8.1)"},{"id":72,"name":"Ruby (2.7.0)"},{"id":73,"name":"Rust (1.40.0)"},{"id":74,"name":"TypeScript (3.7.4)"}]'
        );
    }

    public function createQuery(array $data, $url, $post = true)
    {
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => $post ? 'POST' : 'GET',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        }
        $result = json_decode($result);
        return isset($result) ? $result : false;
    }

    /**
     * @param $languageId
     * @param $code
     * @param Problem $problem
     * @return Submission
     * @throws \Exception
     */
    public function createSubmission($languageId, $code, Problem $problem)
    {
        if (!in_array($languageId, array_keys(Submission::$languages)))
            throw new \Exception('The specified language does not exist');
        if ($code == '')
            throw new \Exception('Code must not be empty');
        if (count($problem->getTests()) < 1)
            throw new \Exception('Problem has no tests');
        $submission = new Submission();
        $submission->setLanguageId($languageId);
        $submission->setCode($code);
        $submission->setProblem($problem);
        $submission->setNextTest($problem->getTests()[0]);
        $submission->setLastStatusId(1);
        $this->entityManager->persist($submission);
        $this->entityManager->flush();
        $this->updateExecution($submission);
        return $submission;
    }

    /**
     * @param Submission $submission
     * @return bool
     * @throws \Exception
     */
    public function runNextTest(Submission $submission)
    {
        $url = $this->getHost().'/submissions';
        $data = [
            "source_code" => $submission->getCode(),
            "language_id" =>  $submission->getLanguageId(),
            "number_of_runs" => "1",
            "stdin" => $submission->getNextTest()->getInput(),
            "expected_output" => $submission->getNextTest()->getOutput(),
            "cpu_time_limit" => "2",
            "cpu_extra_time" => "0.5",
            "wall_time_limit" => "5",
            "memory_limit" => "128000",
            "stack_limit" => "64000",
            "max_processes_and_or_threads" => "30",
            "enable_per_process_and_thread_time_limit" => false,
            "enable_per_process_and_thread_memory_limit" => true,
            "max_file_size" => "1024"
        ];
        $result = $this->createQuery($data, $url);
        if (isset($result->token)) {
            $submission->setToken($result->token);
            $this->entityManager->flush();
            if (!$this->updateExecution($submission)) {
                throw new \Exception('Unable update execution info after new test');
            }
            return $this->setNextTest($submission);
        }
        throw new \Exception('Unable get token for execution. Data:  '.json_encode($result));
    }

    /**
     * @param Submission $submission
     * @return bool|ProblemTest
     */
    public function getNextTest(Submission $submission)
    {
        $tests = $submission->getProblem()->getTests();
        $test = $submission->getNextTest();
        $isChanged = false;
        foreach ($tests as $item) {
            if ($item instanceof ProblemTest) {
                if (isset($tmp) && $tmp->getId() == $test->getId()) {
                    $test = $item;
                    $isChanged = true;
                    break;
                }
                $tmp = $item;
            }
        }
        if ($isChanged) {
            return $test;
        }
        return false;
    }

    /**
     * @param Submission $submission
     * @return bool
     */
    public function setNextTest(Submission $submission)
    {
        if (( $test = $this->getNextTest($submission)) instanceof ProblemTest) {
            $submission->setNextTest($test);
            $this->entityManager->flush();
            return true;
        }
        $submission->setNextTest(null);
        $this->entityManager->flush();
        return false;
    }

    /**s
     * @param Submission $submission
     * @throws \Exception
     */
    public function resetSubmission(Submission $submission)
    {
        if (count($submission->getProblem()->getTests()) < 1)
            throw new \Exception('The problem has no tests');
        $submission->setNextTest($submission->getProblem()->getTests()[0]);
        $this->entityManager->flush();
        $this->runNextTest($submission);
    }

    /**
     * @param Submission $submission
     * @return bool
     * @throws \Exception
     */
    public function updateExecution(Submission $submission)
    {
        $url = $this->getHost().'/submissions/'.$submission->getToken();
        $result = $this->createQuery([], $url, false);
        if (is_object($result)) {
            if (isset($result->status->id)) $submission->setLastStatusId($result->status->id);
            if (isset($result->stdout)) $submission->setStdout($result->stdout);
            if (isset($result->stderr)) $submission->setStderr($result->stderr);
            if (isset($result->time)) $submission->setTime($result->time);
            if (isset($result->memory)) $submission->setMemory($result->memory);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }

    /**
     * @param Submission $submission
     * @return array
     * @throws \Exception
     */
    public function updateSubmission(Submission $submission)
    {
        if (!$this->updateExecution($submission)) {
            $this->resetSubmission($submission);
        }
        if (!$this->updateExecution($submission)) {
            throw new \Exception('Unable update execution info');
        }

        if ($submission->getLastStatusId() > 2) {
            if ($submission->getNextTest() instanceof ProblemTest && $submission->getLastStatusId() == 3) {
                $nextTest = $submission->getNextTest();
                $oldSubmission = [
                    'id' => $submission->getId(),
                    'stdout' => $submission->getStdout(),
                    'stderr' => $submission->getStderr(),
                    'time' => $submission->getTime(),
                    'memory' => $submission->getMemory(),
                    'status' => $submission->getLastStatusId(),
                ];
                $this->runNextTest($submission);
                return [
                    'status' => 2, // next
                    'new_submission' => [
                        'status' => $submission->getLastStatusId(),
                        'stdout' => $submission->getStdout(),
                        'stderr' => $submission->getStderr(),
                        'time' => $submission->getTime(),
                        'memory' => $submission->getMemory(),
                        'test_input' => $nextTest->getInput(),
                        'test_output' => $nextTest->getOutput(),
                        'test_id' => $nextTest->getId(),
                    ],
                    'submission' => $oldSubmission
                ];
            }
            else {
                return [
                    'status' => 3, // ended
                    'is_ended' => true,
                    'submission' => [
                        'id' => $submission->getId(),
                        'status' => $submission->getLastStatusId(),
                        'stdout' => $submission->getStdout(),
                        'stderr' => $submission->getStderr(),
                        'time' => $submission->getTime(),
                        'memory' => $submission->getMemory(),
                    ]
                ];

            }
        }
        else {
            return [
                'status' => 1, // process
                'submission' => [
                    'id' => $submission->getId(),
                    'status' => $submission->getLastStatusId(),
                    'stdout' => $submission->getStdout(),
                    'stderr' => $submission->getStderr(),
                    'time' => $submission->getTime(),
                    'memory' => $submission->getMemory(),
                ]
            ];
        }
    }




}