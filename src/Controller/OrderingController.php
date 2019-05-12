<?php

namespace App\Controller;

use App\Entity\Ordering;
use App\Entity\Product;
use App\Form\OrderingType;
use App\Repository\OrderingRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function new(Request $request): Response
    {
        $ordering = new Ordering();
        $form = $this->createForm(OrderingType::class, $ordering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ordering->setProductPrice($product->getPrice());
            $ordering->setProductName($product->getName());
            $ordering->setStatus('new');
            $product->setStock($product->getStock()-$ordering->getCount());
            $ordering->setTotalPrice($ordering->getCount() * $ordering->getProductPrice() + $ordering->getDelivery()->getPrice() + $ordering->getPayment()->getPrice());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ordering);
            $entityManager->flush();

            return $this->redirectToRoute('thankyou');
        }

        return $this->render('ordering/new.html.twig', [
            'ordering' => $ordering,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordering/new/{id}", name="ordering", methods={"GET","POST"})
     */
    public function order(Request $request, Product $product): Response
    {
        $ordering = new Ordering();
        $form = $this->createForm(OrderingType::class, $ordering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordering->setProductPrice($product->getPrice());
            $ordering->setProductName($product->getName());
            $ordering->setStatus('new');
            $product->setStock($product->getStock() - $ordering->getCount());
            $ordering->setTotalPrice($ordering->getCount() * $ordering->getProductPrice() + $ordering->getDelivery()->getPrice() + $ordering->getPayment()->getPrice());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ordering);
            $entityManager->flush();

            return $this->redirectToRoute('thankyou');
        }

        return $this->render('ordering/new.html.twig', [
            'ordering' => $ordering,
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordering/{id}", name="ordering_show", methods={"GET"})
     */
    public function show(Ordering $ordering): Response
    {
        return $this->render('ordering/show.html.twig', [
            'ordering' => $ordering,
        ]);
    }

    /**
     * @Route("/ordering/{id}/edit", name="ordering_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ordering $ordering, Product $product): Response
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
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordering/{id}", name="ordering_delete", methods={"DELETE"})
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
