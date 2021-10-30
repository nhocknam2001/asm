<?php

namespace App\Form;

use App\Entity\Room;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add(
            'name',
            TextType::class,
            [
                'label' => 'Room Name',
                'required' => true
            ]
        )
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
            // Configure your form options here
        ]);
    }
}
