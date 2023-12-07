<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('montantTotal')
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'en_cours',
                    'En cours de livraison' => 'en cours de livraison',
                    'Livré' => 'livré',
                    'Terminée' => 'terminee',
                    'Annulée' => 'annulée'
                    ]
                ,])
            ->add('utilisateurid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
