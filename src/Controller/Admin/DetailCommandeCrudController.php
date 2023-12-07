<?php

namespace App\Controller\Admin;

use App\Entity\DetailCommande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class DetailCommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetailCommande::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détails')
            ->setEntityLabelInPlural('Détails')
        ;
    }

    /* id quantite prixUnitaire prixTotal commandeid articleid */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideonForm(),
            NumberField::new('quantite')
                ->setFormTypeOption('disabled','disabled'),
            NumberField::new('prixUnitaire')
                ->setFormTypeOption('disabled','disabled')
                ->setLabel('Prix Unitaire en €'),
            NumberField::new('prixTotal')
                ->setFormTypeOption('disabled','disabled')
                ->setLabel('Prix en €'),
            IdField::new('commandeid')
                ->setLabel('ID Commande')
                ->setFormTypeOption('disabled','disabled'),
            IdField::new('articleid')
                ->setLabel('ID Article')
                ->setFormTypeOption('disabled','disabled'),
        ];
    }
    

    private function isCreatePage(string $pageName): bool
    {
         return 'new' === $pageName;
     }
}
