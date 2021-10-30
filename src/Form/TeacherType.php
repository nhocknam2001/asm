<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, 
        [
            'label' => 'Teacher Name',
            'required' => true
        ])
        ->add('birthday', DateType::class, 
        [
            'label' => 'Teacher Birthday',
            'required' => true,
            'widget' => 'single_text'
        ])
        ->add('address', ChoiceType::class,
        [
            'choices' => 
            [
                "Vietnam" => "Vietnam",
                "Singapore" => "Singapore",
                "United States" => "United States",
                "England" => "England",
                "Germany" => "Germany"
            ]
            
        ])
        ->add('gener', ChoiceType::class,
        [
            'choices' => 
            [
                "Male" => "Male",
                "Female" => "Female",
            ]
            
        ])
        ->add('avatar', FileType::class,
        [
            'label' => "Teacher Avatar",
            'data_class' => null,
            'required' => is_null($builder->getData()->getAvatar())
        ])
        ->add('course', EntityType::class,
            [
                'label' => 'Course',
                'class' => Course::class, 
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
