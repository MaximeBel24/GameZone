<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response
    {
        $cartWithData = $cs->cartWithData();
        $total = $cs->total();

        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }
    
    #[Route('/cart/add/{id}', name:'cart_add')]
    public function add($id, CartService $cs, Request $request)
    {
        if($request->request->get('qtAdd'))
        {   
            $qtAdd = $request->request->get('qtAdd');
            $cs->add($id, $qtAdd);
            return $this->redirectToRoute('home');
        }else{
            $cs->add($id);
            return $this->redirectToRoute('app_cart');
        }      
    }

    #[Route('/cart/drop/{id}', name:'cart_drop')]
    public function drop($id, CartService $cs)
    {       
        $cs->less($id);
        return $this->redirectToRoute('app_cart');       
    }

    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove($id, CartService $cs) : Response
    {
        $cs->remove($id);
        return $this->redirectToRoute('app_cart');
         
    }

    #[Route('/cart/orders', name:'cart_orders')]
    public function commander(CartService $cs, EntityManagerInterface $manager)
    {
        //recupérer les information de mon panier
        $cartWithData = $cs->cartWithData();
        //initialisation quantité total
        $qt = 0;
        //récupérer montant total de la commande
        $total = $cs->total();

        $orders = new Orders;
        //set se qui ne change pas
        $orders->setUser($this->getUser())
                ->setTotalPrice($total)
                ->setStatus('en cours de traitement')
                ->setCreatedAt(new \DateTime);
        foreach($cartWithData as $data):
            //récupération du stock
            $stock= $data['products']->getStock();

            //si la différence entre mon stock et ma quantité de products achété est positive
            if($stock - $data['quantity'] >= 0 )
            {   
                //add mon products a la orders
                $orders->addProduct($data['products']);
                //j'ajoute la quantité de se products a ma quantité total
                $qt += $data['quantity'];
                //du coup on modifie les stock avec le nouveau stock
                $data['products']->setStock($stock - $data['quantity']);
            }else
            {
                $this->addFlash('danger',"vous avez dépassez le nombre de t-shirt $data[products] disponible nous avons modifier votre quantité de ce products");

                $cs->modifyQuantity($data['products']->getId(), $data['products']->getStock());
                
                return $this->redirectToRoute('app_account');
            }
        endforeach;
        $orders->setQuantity($qt);
        $manager->persist($orders);
        $manager->flush();
        $cs->deleteCart();
        $this->addFlash('success',"Votre commande est bien en cours de traitement, retrouvez le détail sur votre profil");
        return $this->redirectToRoute('app_account');
            
    }

}
