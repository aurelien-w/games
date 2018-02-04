<?php

namespace App\Form;

use App\Entity\Duel;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DuelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('playerA', EntityType::class, array(
                'class' => Player::class,
                'choice_label' => 'name'
            ))
            ->add('scoreA', IntegerType::class)
            ->add('scoreB', IntegerType::class)
            ->add('playerB', EntityType::class, array(
                'class' => Player::class,
                'choice_label' => 'name'
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Duel::class,
        ));
    }
}