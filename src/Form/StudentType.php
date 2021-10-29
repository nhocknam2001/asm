<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, 
        [
            'label' => 'Student Name',
            'required' => true
        ])
        ->add('birthday', DateType::class, 
        [
            'label' => 'Student Birthday',
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
        ->add('avatar', FileType::class,
        [
            'label' => "Student Avatar",
            'data_class' => null,
            'required' => is_null($builder->getData()->getAvatar())
        ])
        ->add('category', EntityType::class,
        [
            'label' => "Category",
            'class' => Category::class,
            'choice_label' => "name",  
            'multiple' => false,       
            'expanded' => false        
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
