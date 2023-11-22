<?php

namespace App\Controller;

use App\Entity\Products;
use jcobhams\NewsApi\NewsApi;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductsRepository $repo): Response
    {
        $playstation = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'Playstation')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        $xbox = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'Xbox')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        $nintendo = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'nintendo')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        $pc = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'pc')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        $newsapi = new NewsApi('a0a542601da24e418202c6a891a7c2ff');
        $response = $newsapi->getEverything('gaming', null, null, null, null, null, 'fr', 'publishedAt', 6, null);
        $articles = $response->articles;

        $consoles = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'consoles')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        $manettes = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'manettes')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        $materielpc = $repo->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c')
        ->where('c.name = :categoryName')
        ->setParameter('categoryName', 'materielpc')
        ->orderBy('p.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'playstation' => $playstation,
            'xbox' => $xbox,
            'nintendo' => $nintendo,
            'pc' => $pc,
            'articles' => $articles,
            'consoles' => $consoles,
            'manettes' => $manettes,
            'materielpc'=> $materielpc
        ]);
    }

    #[Route('/account/orders', name:"app_account")]
    public function accountOrders()
    {
        return $this->render('app/account.html.twig');
    }

}
