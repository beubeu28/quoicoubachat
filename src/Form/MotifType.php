<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotifType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Sélectionnez un motif' => '',
                'Article manquant' => 'Article manquant',
                'Divers' => 'Divers',
                'Echange produit' => 'Echange produit',
                'Produits défectueux' => 'Produits défectueux',
                'Problème de livraison' => 'Problème de livraison',
                'Remboursement' => 'Remboursement',
                'Retour produit' => 'Retour produit',
                'Service client' => 'Service client',
            ],
            'label' => 'Motif de contact',
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
