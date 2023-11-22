<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/orders')]
class AdminOrdersController extends AbstractController
{
    #[Route('/', name: 'app_admin_orders')]
    public function index(OrdersRepository $repo, EntityManagerInterface $manager): Response
    {
        $colonnes = $manager->getClassMetadata(Orders::class)->getFieldNames();
        $orders = $repo->findAll();
        return $this->render('admin_orders/index.html.twig', [
        'orders' => $orders,
        'colonnes' => $colonnes
    ]);
}

#[Route('/{id}/edit', name: 'app_admin_orders_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Orders $orders, OrdersRepository $OrdersRepository, EntityManagerInterface $manager): Response
{
    $form = $this->createForm(OrdersType::class, $orders);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($orders);
        $manager->flush();
        $this->addFlash("success", "La catégorie a bien été modifié !");

        return $this->redirectToRoute('app_admin_orders', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('admin_orders/edit.html.twig', [
        'orders' => $orders,
        'form' => $form,
    ]);
}

#[Route("/delete/{id}", name:"app_admin_orders_delete")]
public function delete(Orders $orders = null, EntityManagerInterface $manager)
{
    if ($orders) {
        $manager->remove($orders);
        $manager->flush();
        $this->addFlash('success', 'La catégorie a bien été supprimée !');
    }
    return $this->redirectToRoute('app_admin_orders');
}
}
