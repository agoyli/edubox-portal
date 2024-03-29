<?php


namespace EduBoxBundle\Controller;


use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\User;
use EduBoxBundle\Form\Type\CodeSubmitType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProblemController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/problem/list", name="edubox_problem_list")
     */
    public function listAction(Request $request, PaginatorInterface $paginator)
    {
        $problemManager = $this->get('edubox_problem_manager');
        return $this->render('@EduBox/Front/problem/list.html.twig', [
            'problems' => $paginator->paginate(
                $problemManager->getProblemsBy($request),
                $request->query->getInt('page', 1),
                12
            ),
            'categories' =>  $problemManager->getCategories(),
            'tags' =>  $problemManager->getTags(),
        ]);

    }

    /**
     * @param Request $request
     * @param Problem $problem
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/problem/{id}/show", name="edubox_problem_show")
     */
    public function showAction(Request $request, Problem $problem)
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            $submissionManger = $this->get('edubox_submission_manager');
            $languages = $submissionManger->getLanguages();
            $languages = is_array($languages) ? $languages : [];
            $form = $this->createForm(CodeSubmitType::class, null, ['languages' => $languages]);
            if ($json = $this->get('edubox_code_submit_handler')->handle($form, $request, $problem)) {
                return new JsonResponse($json);
            }
        }
        return $this->render('@EduBox/Front/problem/show.html.twig', [
            'problem' => $problem,
            'codeForm' => isset($form) ? $form->createView() : null,
        ]);
    }

    /**
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/submissions/{type}", name="edubox_problem_submissions", defaults={"type":"all"})
     */
    public function showSubmissionsAction($type = 'all')
    {
        $submissions = $this->getDoctrine()->getRepository('EduBoxBundle:Submission')->findBy([], ['createdAt' => 'desc']);
        return $this->render('@EduBox/Front/problem/submissions.html.twig', [
            'submissions' => $submissions,
            'me' => $type == 'me' ? true : false,
        ]);
    }
}