<?php

namespace App\Controller\Admin;


use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categories')]
class CategorieController extends AbstractController
{
    #[Route('', name: 'app_admin_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $categories = $categorieRepository->findAll();

        return $this->render('admin/categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/new', name: 'app_admin_categorie_new', methods: ['GET', 'POST'])]
    public function new(

        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'La catégorie est bien enregistrée.'
            );

            return $this->redirectToRoute('app_admin_categorie_index');
        }

        return $this->render('admin/categorie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
