<?php

namespace App\Controller;

use App\Entity\DetailCommande;
use App\Entity\Commande;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    private $entityManager;

    #[Route('/ajout/{id}', name: 'app_article_ajout', methods: ['GET'])]
public function ajout(
    int $id,
    Request $request,
    EntityManagerInterface $entityManager,
    ArticleRepository $articleRepository,
    CommandeRepository $commandeRepository,
    DetailCommandeRepository $detailCommandeRepository
): Response {
    $user = $this->getUser();

    if (!$user) {
        return $this->redirectToRoute('app_login');
    }

    $article = $articleRepository->find($id);
    $commande = $commandeRepository->findCurrentCommandeByUser($user);

    if (!$commande) {
        $commande = new Commande();
        $commande->setDate(new \DateTime());
        $commande->setStatut('En cours');
        $commande->setUtilisateurId($user);
        $entityManager->persist($commande);
    }

    $detailCommande = $detailCommandeRepository->findCurrentDetailCommandeByArticle($id);

    if (!$detailCommande) {
        $detailCommande = new DetailCommande();
        $detailCommande->setArticleId($article);
        $detailCommande->setQuantite(1);
        $detailCommande->setPrixUnitaire($article->getPrix());
        $detailCommande->setPrixTotal($detailCommande->getQuantite() * $detailCommande->getPrixUnitaire());
        $commande->addDetailCommande($detailCommande);
    } else {
        $detailCommande->setQuantite($detailCommande->getQuantite() + 1);
        $detailCommande->setPrixTotal($detailCommande->getQuantite() * $detailCommande->getPrixUnitaire());
    }

    $commande->setMontantTotal(0); // Remise à zéro pour recalculer
    foreach ($commande->getDetailCommandes() as $detail) {
        $commande->setMontantTotal($commande->getMontantTotal() + $detail->getPrixTotal());
    }

    $entityManager->persist($detailCommande);
    $entityManager->flush();

    return $this->redirectToRoute('app_article_show');
}

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
