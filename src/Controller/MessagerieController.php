<?php

namespace App\Controller;
use App\Entity\Messagerie;
use App\Form\MessagerieType;
use App\Repository\MessagerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/messagerie')]
class MessagerieController extends AbstractController
{
    #[Route('/', name: 'app_messagerie_index', methods: ['GET'])]
    public function index(MessagerieRepository $messagerieRepository): Response
    {
        $user = $this->getUser();
            if (!$user) {
        return $this->redirectToRoute('app_login');
        }
        return $this->render('messagerie/index.html.twig', [
        'messageries' => $messagerieRepository->findAll(),
        ]);
      
        
    }

    #[Route('/new', name: 'app_messagerie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $messagerie = new Messagerie();
        $user = $this->getUser();
    
        if ($user !== null) {
            $userEmail = $user->getEmail();
            $messagerie->setUserMail($userEmail);
    
            $form = $this->createForm(MessagerieType::class, $messagerie);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($messagerie);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_messagerie_mesDemandes');
            }
    
            return $this->renderForm('messagerie/new.html.twig', [
                'messagerie' => $messagerie,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('app_register');
        }
    }

    #[Route('/mesDemandes', name: 'app_messagerie_mesDemandes', methods: ['GET', 'POST'])]
    public function mesDemandes(MessagerieRepository $messagerieRepository): Response
    {
        $user = $this->getUser();
        if ($user !== null) {
            $role = $user->getRoles();
            $mail = $user->getEmail();
            $mesDemandes = $messagerieRepository->mesDemandes($mail);

            return $this->render('messagerie/demandes.html.twig', [
                'mesDemandes' => $mesDemandes,
            ]);
        }else{
            return $this->redirectToRoute('app_register');
        }
    }


    #[Route('/{id}', name: 'app_messagerie_show', methods: ['GET'])]
    public function show(Messagerie $messagerie): Response
    {
        $user = $this->getUser();
        if ($user !== null) {
            return $this->render('messagerie/show.html.twig', [
                'messagerie' => $messagerie,
            ]);
        }else{
            return $this->redirectToRoute('app_register');
        }
    }

    #[Route('/{id}/edit', name: 'app_messagerie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Messagerie $messagerie, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user !== null) { 
            $form = $this->createForm(MessagerieType::class, $messagerie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_messagerie_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('messagerie/edit.html.twig', [
                'messagerie' => $messagerie,
                'form' => $form,
            ]);
        }else{
            return $this->redirectToRoute('app_register');
        }
       
    }

    #[Route('/{id}', name: 'app_messagerie_delete', methods: ['POST'])]
    public function delete(Request $request, Messagerie $messagerie, EntityManagerInterface $entityManager): Response
    { $user = $this->getUser();
        if ($user !== null) { 
            if ($this->isCsrfTokenValid('delete'.$messagerie->getId(), $request->request->get('_token'))) {
                $entityManager->remove($messagerie);
                $entityManager->flush();
            }

            // Redirection vers la page précédente (referer)
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }else{
            return $this->redirectToRoute('app_register');
        }
    } 
}
