<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    /**
     * @Route("/basket", name="basket_index")
     */
    public function basketIndex(SessionInterface $session)
    {
        $basket = $session->get('basket', []);

        if ($basket == []){
            $h1 = 'Košík je prázdný!';
        } else {
            $h1 = '';
        }

        return $this->render('basket/index.html.twig', [
            'basket' => $basket,
            'h1' => $h1
        ]);
    }

    /**
     * @Route("/basket/add_to_cart/{id}", name="basket_add_to_cart")
     */
    public function basketAddToCart(Product $product, SessionInterface $session, Request $request)
    {

        $count = $request->query->get('count');

        $basket = $session->get('basket', []);

        $basket[$product->getId()] = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'count' => $count
            ];

        $session->set('basket', $basket);
        return $this->redirectToRoute('basket_index');
    }

    /**
     * @Route("/basket/increase/{id}", name="basket_increase_count")
     */
    public function basketIncrease(SessionInterface $session, Product $product)
    {
        $basket = $session->get('basket', []);
        $basket[$product->getId()]['count']++;
        $session->set('basket', $basket);
        return $this->redirectToRoute('basket_index');
    }

    /**
     * @Route("/basket/decrease/{id}", name="basket_decrease_count")
     */
    public function basketDecrease(SessionInterface $session, Product $product)
    {
        $basket = $session->get('basket', []);

        if ($basket[$product->getId()]['count'] === 1) {
            unset($basket[$product->getId()]);
        } else {
            $basket[$product->getId()]['count']--;
        }

        $session->set('basket', $basket);
        return $this->redirectToRoute('basket_index');
    }

    /**
     * @Route("/basket/remove_from_cart/{id}", name="basket_remove_from_cart")
     */
    public function basketRemoveFromCart(SessionInterface $session, Product $product)
    {
        $basket = $session->get('basket', []);
        unset($basket[$product->getId()]);
        $session->set('basket', $basket);
        return $this->redirectToRoute('basket_index');

    }

    /**
     * @Route("/basket/dump_cart", name="basket_dump")
     */
    public function basketDumpCart(SessionInterface $session)
    {
        $basket = [];
        $session->set('basket', $basket);
        return $this->redirectToRoute('basket_index', [
            'h1' => 'Některý z výrobků již není dostupný!'
        ]);
    }
}
