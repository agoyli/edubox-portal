<?php


namespace EduBoxBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ExamplesJsonType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('examples', FormType::class);
        $builder->get('examples')
            ->add('1', FormType::class);
        $builder->get('examples')->get('1')
            ->add('input', TextareaType::class, ['required' => false])
            ->add('output', TextareaType::class, ['required' => false]);
        $builder->get('examples')
            ->add('2', FormType::class);
        $builder->get('examples')->get('2')
            ->add('input', TextareaType::class, ['required' => false])
            ->add('output', TextareaType::class, ['required' => false]);
        $builder->get('examples')
            ->add('3', FormType::class);
        $builder->get('examples')->get('3')
            ->add('input', TextareaType::class, ['required' => false])
            ->add('output', TextareaType::class, ['required' => false]);
    }

    public function getBlockPrefix()
    {
        return 'examples_json';
    }
}