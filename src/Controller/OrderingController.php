<?php

namespace App\Controller;

use App\Entity\Ordering;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Form\OrderingType;
use App\Repository\OrderingRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class OrderingController extends AbstractController
{
    /**
     * @Route("/admin/ordering", name="ordering_index", methods={"GET"})
     */
    public function index(OrderingRepository $orderingRepository): Response
    {
        return $this->render('ordering/index.html.twig', [
            'orderings' => $orderingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ordering", name="ordering_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $ordering = new Ordering;

        $form = $this->createForm(OrderingType::class, $ordering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $products = $session->get('basket');

            foreach ($products as $product) {
                $orderProduct = new OrderProduct;
                $orderProduct->setProductId($product['id']);
                $orderProduct->setName($product['name']);
                $orderProduct->setPrice($product['price']);
                $orderProduct->setAmount($product['count']);

                $this->getDoctrine()->getManager()->persist($orderProduct);
                $ordering->addProduct($orderProduct);

                $orderedProducts = $ordering->getOrderedProducts();

            }

            $totalProductsPrice = 0
                foreach ($orderedProducts as $orderedProduct){
                    $totalProductsPrice += $orderedProduct['price'];

                };
                $ordering->setTotalPrice(
                    $ordering->getDelivery()->getPrice() +
                    $ordering->getPayment()->getPrice() +
                    $totalProductsPrice
                );

            $ordering->setStatus('new');
            //$product->setStock($product->getStock()-$ordering->getCount());
            //$ordering->setTotalPrice(;

            $this->getDoctrine()->getManager()->persist($ordering);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('thankyou');
        }

        return $this->render('ordering/new.html.twig', [
            'ordering' => $ordering,
            'form' => $form->createView(),
            'products' => $session->get('basket')
        ]);
    }

    /**
     * @Route("/admin/ordering/{id}", name="ordering_show", methods={"GET"})
     */
    public function show(Ordering $ordering): Response
    {
        return $this->render('ordering/show.html.twig', [
            'ordering' => $ordering,
        ]);
    }

    /**
     * @Route("admin/ordering/{id}/edit", name="ordering_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ordering $ordering): Response
    {
        $form = $this->createForm(OrderingType::class, $ordering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ordering_index', [
                'id' => $ordering->getId(),
            ]);
        }

        return $this->render('ordering/edit.html.twig', [
            'ordering' => $ordering,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ordering/{id}", name="ordering_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ordering $ordering): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordering->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ordering);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordering_index');
    }
}
