<?php

namespace App\Controller\Admin;

use App\Entity\Ticket;
use App\Form\TicketEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tickets')]
final class TicketController extends AbstractController
{

    #[Route('/{id}/edit', name: 'app_admin_ticket_edit', methods: ['GET', 'POST'])]
    public function modifierTicket(
        Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TicketEditType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelEtat = $form->get('etat')->getData();
            $ticket->getEtat();

            if ($nouvelEtat->isCloturant()) {
                if ($ticket->getDateCloture() === null) {
                    $ticket->setDateCloture(
                        new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
                    );
                }
            } else {
                $ticket->setDateCloture(null);
            }


            $entityManager->flush();
            $this->addFlash('success', 'Le ticket a été modifié avec succès.');

            return $this->redirectToRoute('app_ticket_index');
        }

        return $this->render('admin/ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
