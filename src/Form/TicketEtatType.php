<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketEtatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('etat', EntityType::class, [
            'class' => Etat::class,
            'choice_label' => 'nom',
            'label' => 'Nouvel état du ticket',
            'placeholder' => 'Sélectionnez un état',
        ])
            ->add('responsable', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Responsable du ticket',
                'placeholder' => 'Aucun responsable',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
