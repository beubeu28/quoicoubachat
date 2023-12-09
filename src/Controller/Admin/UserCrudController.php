<?php

namespace App\Controller\Admin;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormTypeInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
        ;
    }

    public static function getEntityId(): string
    {
        return User::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        $rolesOptions = [
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_LOCK' => 'ROLE_LOCK',
            'ROLE_MANAGER' => 'ROLE_MANAGER',
        ];
        
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            
            ChoiceField::new('roles')
                ->setChoices($rolesOptions)
                ->allowMultipleChoices()
                ->setRequired(true)
                ->setFormTypeOptions([
                    'choices' => $rolesOptions,
                    ])
                ->onlyOnForms(),
                ArrayField::new('roles')->onlyOnIndex(),
                TextField::new('telephone'),
        ];
    }

    private function isEditPage(string $pageName): bool
    {
        return 'edit' === $pageName;
    }
    
}
