<?php

namespace App\Controller;

use App\Form\TicketEtatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Ticket;
use App\Entity\User;

#[Route('/tickets')]
class TicketController extends AbstractController
{
    #[Route('', name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $tickets = $ticketRepository->findBy(
            [],
            ['dateOuverture' => 'DESC']
        );

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/etat', name: 'app_ticket_etat', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function modifierEtat(
        Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(TicketEtatType::class, [
            'etat' => $ticket->getEtat(),
            'responsable' =>$ticket->getResponsable(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelEtat = $form->get('etat')->getData();
            $ticket->setEtat($nouvelEtat);

            $nouveauResponsable = $form->get('responsable')->getData();
            $ticket->setResponsable($nouveauResponsable);

            if ($nouvelEtat->getNom() === 'Fermé') {
                if ($ticket->getDateCloture() === null) {
                    $ticket->setDateCloture(
                        new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
                    );
                }
            } else {
                $ticket->setDateCloture(null);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le ticket n°' . $ticket->getId() . ' a été mis à jour avec succès.');

            return $this->redirectToRoute('app_ticket_show', [
                'id' => $ticket->getId(),
            ]);
        }

        return $this->render('ticket/etat.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
