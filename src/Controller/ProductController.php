<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route("/show/{id}", name: "show_products")]
    public function show( Products $products) :Response
    {
        if($products == null)
        {
            return $this->redirectToRoute('home');
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }


}
