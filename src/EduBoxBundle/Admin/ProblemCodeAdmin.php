<?php


namespace EduBoxBundle\Admin;


use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\ProblemCode;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProblemCodeAdmin extends AbstractAdmin
{
    protected $baseRouteName = "edubox_admin_problem_code";
    protected $baseControllerName = "problem_code";


    protected function configureFormFields(FormMapper $form)
    {
        $form->add('problem', EntityType::class, [
            'class' => Problem::class,
        ]);
        $form->add('language', ChoiceType::class, [
            'choices' => array_flip(ProblemCode::$languages),
        ]);
        $form->add('code', TextareaType::class);
    }

    public function getNewInstance()
    {
        $object = $this->getModelManager()->getModelInstance($this->getClass());
        foreach ($this->getExtensions() as $extension) {
            $extension->alterNewInstance($this, $object);
        }

        $problemId = $this->getRequest()->get('problem_id');
        if ($problemId > 0) {
            $object->setProblem(
                $this->getConfigurationPool()
                    ->getContainer()
                    ->get('doctrine.orm.entity_manager')
                    ->getRepository('EduBoxBundle:Problem')
                    ->find($problemId)
            );
        }

        return $object;
    }

}