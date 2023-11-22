<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\ProductsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoriesRepository $crepo,ProductsRepository $prepo): Response
    {
        $products = $prepo->findAll();
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $crepo->findBy([],
            ['id' => 'asc']),
            'products' => $products
        ]);
    }

    #[Route('categories/{slug}', name: 'list')]
    public function details(Categories $category): Response
    {
        $products = $category->getProducts();

        return $this->render('categories/list.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
