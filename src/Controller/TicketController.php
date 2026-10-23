<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}