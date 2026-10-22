<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        EtatRepository $etatRepository
    ): Response {
        // Création d'un nouveau ticket
        $ticket = new Ticket();

        // Création du formulaire
        $form = $this->createForm(TicketType::class, $ticket);

        // Récupération des données envoyées
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Recherche de l'état initial
            $etatNouveau = $etatRepository->findOneBy([
                'nom' => 'Nouveau'
            ]);

            if (!$etatNouveau) {
                throw $this->createNotFoundException(
                    "L'état Nouveau n'existe pas."
                );
            }

            // Attribution automatique de l'état
            $ticket->setEtat($etatNouveau);

            // Enregistrement dans MySQL
            $entityManager->persist($ticket);
            $entityManager->flush();

            // Message de confirmation
            $this->addFlash(
                'success',
                'Votre ticket a bien été enregistré.'
            );

            // Redirection pour éviter une double soumission
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}