<?php


namespace EduBoxBundle\Controller;


use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\User;
use EduBoxBundle\Form\Type\CodeSubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProblemController extends Controller
{
    /**
     * @Route(path="/problem/list", name="edubox_problem_list")
     */
    public function listAction(Request $request)
    {
        $problems = $this->getDoctrine()->getRepository('EduBoxBundle:Problem')->createQueryBuilder('p');

        $categoryId = (int)$request->get('category');
        $tagId = (int)$request->get('tag');
        $search = $request->get('search');

        if ($categoryId > 0) {
            $problems->leftJoin('p.categories', 'c')
                ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if ($tagId > 0) {
            $problems->leftJoin('p.tags', 't')
                ->where('t.id = :tagId')->setParameter('tagId', $tagId);
        }

        if (strlen($search) > 0) {
            $problems
                ->andWhere(
                    $problems->expr()->like('CONCAT(lower(p.name),lower(p.description))', $problems->expr()->literal('%'.$search.'%'))
                );
        } else {
            $search = null;
        }

        $categories = $this->getDoctrine()->getRepository('ApplicationSonataClassificationBundle:Category')->findBy(['context' => 'problem']);
        $tags = $this->getDoctrine()->getRepository('ApplicationSonataClassificationBundle:Tag')->findBy(['context' => 'problem']);
        $problems = $problems->getQuery()->getResult();
        return $this->render('@EduBox/Front/problem/list.html.twig', [
            'problems' => $problems,
            'categories' =>  $categories,
            'tags' =>  $tags,
            'categoryId' => $categoryId,
            'tagId' => $tagId,
            'search' => $search,
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

    public function executeAction()
    {

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