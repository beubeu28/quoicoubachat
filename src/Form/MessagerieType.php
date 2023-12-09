<?php

namespace App\Form;

use App\Entity\Messagerie;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MessagerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motif', ChoiceType::class, [ 'choices' => [
                'Sélectionnez un motif' => '',
                'Article manquant' => 'Article manquant',
                'Divers' => 'Divers',
                'Echange produit' => 'Echange produit',
                'Produits défectueux' => 'Produits défectueux',
                'Problème de livraison' => 'Problème de livraison',
                'Recrutement' => 'Recrutement',
                'Remboursement' => 'Remboursement',
                'Retour produit' => 'Retour produit',
                'Service client' => 'Service client'
            ],
            'label' => 'Motif de contact',
        ])
            ->add('description')

            ->add('imageFile', VichImageType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messagerie::class,
        ]);
    }
}
