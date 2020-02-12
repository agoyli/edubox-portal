<?php


namespace EduBoxBundle\Form\Type;


use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeSubmitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $languages = [];
        foreach ($options['languages'] as $language) {
            $languages[$language->name] = $language->id;
        }

        $builder->add('language', ChoiceType::class, [
            'label' => 'Programmalaşdyrmak dili',
            'choices' => $languages,
            'preferred_choices' => [34],
        ]);
        $builder->add('code', TextareaType::class, [
            'label' => 'Kod',
        ]);
        $builder->add('submission', HiddenType::class, [
            'mapped' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'languages' => [],
        ]);
    }
}