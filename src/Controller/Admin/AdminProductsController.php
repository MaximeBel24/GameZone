<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/products')]

class AdminProductsController extends AbstractController
{
    #[Route('/', name: 'app_admin_products')]
    public function index(ProductsRepository $repo, EntityManagerInterface $manager): Response
    {
        $colonnes = $manager->getClassMetadata(Products::class)->getFieldNames();
        $products = $repo->findAll();
        return $this->render('admin_products/index.html.twig', [
            'products' => $products,
            'colonnes' => $colonnes
        ]);
    }

    #[Route('/new', name: 'app_admin_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductsRepository $productsRepository, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $products = new Products();
        $form = $this->createForm(ProductsType::class, $products);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture->move(
                        $this->getParameter('picture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
            }
            $products->setPicture($newFilename);
            $products->setCreatedAt(new \DateTime);
            $manager->persist($products);
            $manager->flush();
            $this->addFlash("success", "Le produit a bien été enregistré !");
            return $this->redirectToRoute('app_admin_products');
        }

        return $this->renderForm('admin_products/form.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $products, ProductsRepository $productsRepository, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProductsType::class, $products);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture->move(
                        $this->getParameter('picture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
            }
            $products->setPicture($newFilename);
            $manager->persist($products);
            $manager->flush();
            $this->addFlash("success", "Le produit a bien été modifié !");

            return $this->redirectToRoute('app_admin_products', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_products/edit.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }

    #[Route("/delete/{id}", name:"app_admin_products_delete")]
    public function delete(products $products = null, EntityManagerInterface $manager)
    {
        if ($products) {
            $manager->remove($products);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été supprimée !');
        }
        return $this->redirectToRoute('app_admin_products');
    }
}
