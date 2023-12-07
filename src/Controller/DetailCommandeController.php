<?php

namespace App\Controller;

use App\Entity\DetailCommande;
use App\Form\DetailCommandeType;
use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/detail/commande')]
class DetailCommandeController extends AbstractController
{
    
    #[Route('/moins/{id}', name: 'app_detail_commande_moins', methods: ['POST'])]
    public function qmoins(Request $request, EntityManagerInterface $entityManager, DetailCommande $detailCommande): Response {
        $commande = $detailCommande->getCommandeid();
        $article = $detailCommande->getArticleid();
        $newQuantity = $detailCommande->getQuantite() - 1;
    
        $article->setStock($article->getStock() + 1);
        $detailCommande->setQuantite($newQuantity);
        $detailCommande->setPrixTotal($newQuantity * $detailCommande->getPrixUnitaire());
    
        if ($newQuantity == 0) {
            $commande->removeDetailCommande($detailCommande); // Assurez-vous que la méthode removeDetailCommande est définie dans votre entité Commande
            $entityManager->remove($detailCommande);
        }
        $commande->recalculateMontantTotal();
        $entityManager->flush();
    
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
    
    #[Route('/plus{id}', name: 'app_detail_commande_plus', methods: ['POST'])]
    public function qplus(Request $request, EntityManagerInterface $entityManager, DetailCommande $detailCommande): Response {
        $commande = $detailCommande->getCommandeid();
        $article = $detailCommande->getArticleid();
        if($article->getStock()==0){
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $newQuantity = $detailCommande->getQuantite() + 1;
    
        $article->setStock($article->getStock() - 1);
        $detailCommande->setQuantite($newQuantity);
        $detailCommande->setPrixTotal($newQuantity * $detailCommande->getPrixUnitaire());
        $commande->recalculateMontantTotal();
        $entityManager->flush();
    
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/', name: 'app_detail_commande_index', methods: ['GET'])]
    public function index(DetailCommandeRepository $detailCommandeRepository): Response
    {
        return $this->render('detail_commande/index.html.twig', [
            'detail_commandes' => $detailCommandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_detail_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $detailCommande = new DetailCommande;
        $form = $this->createForm(DetailCommandeType::class, $detailCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($detailCommande);
            $entityManager->flush();

            return $this->redirectToRoute('app_detail_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detail_commande/new.html.twig', [
            'detail_commande' => $detailCommande,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_detail_commande_show', methods: ['GET'])]
    public function show(DetailCommande $detailCommande): Response
    {
        return $this->render('detail_commande/show.html.twig', [
            'detail_commande' => $detailCommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detail_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetailCommande $detailCommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DetailCommandeType::class, $detailCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_detail_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detail_commande/edit.html.twig', [
            'detail_commande' => $detailCommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detail_commande_delete', methods: ['POST'])]
    public function delete(Request $request, DetailCommande $detailCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($detailCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_detail_commande_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
