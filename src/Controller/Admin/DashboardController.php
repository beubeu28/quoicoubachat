<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Messagerie;
use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\DetailCommande;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        try {
            return $this->render('admin/dashboard.html.twig');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('/');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Quoicoubachat')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Messagerie', 'fas fa-message', Messagerie::class);
        yield MenuItem::linkToCrud('Article', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Commande', 'fas fa-box', Commande::class);
        yield MenuItem::linkToCrud('Détails Commande', 'fas fa-circle-info', DetailCommande::class);
    }
}
