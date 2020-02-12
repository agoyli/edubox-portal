<?php


namespace EduBoxBundle\Form;


use EduBoxBundle\DomainManager\SubmissionManager;
use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\Submission;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CodeSubmitHandler
{
    private $submissionManager;

    public function __construct(SubmissionManager $submissionManager)
    {
        $this->submissionManager = $submissionManager;
    }

    public function handle(FormInterface $form, Request $request, Problem $problem)
    {
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted())
        {
            $submission = (int)$form->get('submission')->getData();
            if ($submission < 1) {
                try {
                    $submission = $this->submissionManager->createSubmission(
                        $form->get('language')->getData(),
                        $form->get('code')->getData(),
                        $problem
                    );
                } catch (\Exception $exception) {
                    return ['status' => -1, 'message' => $exception->getMessage()];
                }
            }
            else {
                $submission = $this->submissionManager->getObject($submission);
            }
            try {
                if (!$submission instanceof Submission) throw new \Exception('Submission not found');
                return $this->submissionManager->updateSubmission($submission);
            } catch (\Exception $exception) {
                return ['status' => -1, 'message' => $exception->getMessage()];
            }
        }
        return false;
    }

}