<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\DetailCommande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/manager', name: 'app_commande_index', methods: ['GET'])]
    #[IsGranted('ROLE_MANAGER')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $id = $user->getId();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_detail_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
       // return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    #[IsGranted('ROLE_MANAGER')]
    public function show(Commande $commande): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]

    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }


    #[Route('/modifier/{id}', name: 'app_commande_modifier', methods: ['POST'])]
    public function modifierStatut(Request $request, EntityManagerInterface $entityManager,int $id): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $var = $request->request->get('var');
        $commandeId = $request->request->get('id');
    
        $commande = $entityManager->getRepository(Commande::class)->find($commandeId);
    
        $commande->setStatut($var);
        $commande->setDate($commande->getDate());
        
        $commande = $entityManager->getRepository(Commande::class)->find($id);
        $entityManager->persist($commande);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/valider{id}', name: 'app_commande_valider', methods: ['POST'])]
    public function validerCommande(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $userid = $user->getId();
        $commande = $entityManager->getRepository(Commande::class)->find($id);
        $commande->setStatut("En cours de livraison");
        $commande->setDate($commande->getDate());
        
    
        // Rechargez la commande depuis la base de données
        $commande = $entityManager->getRepository(Commande::class)->find($commande);
        $entityManager->persist($commande);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_commande_mescommandes', ['id'=>$userid], Response::HTTP_SEE_OTHER);

    }
    

    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $id = $commande->getId();
    
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/mescommandes/{id}', name: 'app_commande_mescommandes', methods: ['GET', 'POST'])]
    public function mescommandes(CommandeRepository $commandeRepository,int $id): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $commandes = $commandeRepository->findAllCommandeById($id);
        return $this->render('commande/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }


}
