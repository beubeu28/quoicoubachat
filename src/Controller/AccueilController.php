<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/Rechercher', name: 'Rechercher', methods: ['GET'])]
    public function Rechercher(Request $request, ArticleRepository $articleRepository): Response
    {
        $Rechercher = $request->query->get('Rechercher');
        $articles = $articleRepository->filtre($Rechercher, null, null, null, null, null);

        return $this->render('article/index.html.twig', [
            'Rechercher' => $Rechercher,
            'articles' => $articles,
        ]);
    }
}
