<?php

namespace App\Controller\Admin;

use App\Entity\Messagerie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class MessagerieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Messagerie::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
        ;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Message')
            ->setEntityLabelInPlural('Messagerie')
        ;
    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('usermail')
                ->setFormTypeOption('disabled', 'disabled')
                ->setLabel('Utilisateur'),
            TextField::new('motif')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('description')
                ->setFormTypeOption('disabled', 'disabled')   
                ->setLabel('Message'),
            IdField::new('utilisateur')
                ->hideOnIndex()
                ->hideOnForm(),
            DateTimeField::new('date')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('reponse')
                ->setLabel('Réponse'),

        ];
    }
    

}
