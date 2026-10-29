<?php

namespace App\Controller\Admin;

use App\Entity\Etat;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EtatType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/etats')]
final class EtatController extends AbstractController
{
    #[Route('', name: 'app_admin_etat_index', methods: ['GET'])]

    public function index(EtatRepository $etatRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $etats = $etatRepository->findAll();

        return $this->render('admin/etat/index.html.twig', [
            'etats' => $etats,

        ]);
    }

    #[Route('/new', name: 'app_admin_etat_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $etat = new Etat();

        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etat);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'état est bien enregistré.'
            );

            return $this->redirectToRoute('app_admin_etat_index');
        }

        return $this->render('admin/etat/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
