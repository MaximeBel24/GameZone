<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/categories')]
class AdminCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_admin_categories')]
    public function index(CategoriesRepository $repo, EntityManagerInterface $manager): Response
    {
        $colonnes = $manager->getClassMetadata(Categories::class)->getFieldNames();
        $categories = $repo->findAll();
        return $this->render('admin_categories/index.html.twig', [
            'categories' => $categories,
            'colonnes' => $colonnes
        ]);
    }

    #[Route('/new', name: 'app_admin_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoriesRepository $categoriesRepository, EntityManagerInterface $manager): Response
    {
        $categories = new Categories();
        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categories);
            $manager->flush();
            $this->addFlash("success", "La catégorie a bien été enregistré !");
            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->renderForm('admin_categories/form.html.twig', [
            'categories' => $categories,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $categories, CategoriesRepository $categoriesRepository, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categories);
            $manager->flush();
            $this->addFlash("success", "La catégorie a bien été modifié !");

            return $this->redirectToRoute('app_admin_categories', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_categories/edit.html.twig', [
            'categories' => $categories,
            'form' => $form,
        ]);
    }

    #[Route("/delete/{id}", name:"app_admin_categories_delete")]
    public function delete(Categories $categories = null, EntityManagerInterface $manager)
    {
        if ($categories) {
            $manager->remove($categories);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été supprimée !');
        }
        return $this->redirectToRoute('app_admin_categories');
    }
}
