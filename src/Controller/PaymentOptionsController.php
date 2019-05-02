<?php

namespace App\Controller;

use App\Entity\PaymentOptions;
use App\Form\PaymentOptionsType;
use App\Repository\PaymentOptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/payment")
 */
class PaymentOptionsController extends AbstractController
{
    /**
     * @Route("/", name="payment_options_index", methods={"GET"})
     */
    public function index(PaymentOptionsRepository $paymentOptionsRepository): Response
    {
        return $this->render('payment_options/index.html.twig', [
            'payment_options' => $paymentOptionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_options_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paymentOption = new PaymentOptions();
        $form = $this->createForm(PaymentOptionsType::class, $paymentOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentOption);
            $entityManager->flush();

            return $this->redirectToRoute('payment_options_index');
        }

        return $this->render('payment_options/new.html.twig', [
            'payment_option' => $paymentOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_options_show", methods={"GET"})
     */
    public function show(PaymentOptions $paymentOption): Response
    {
        return $this->render('payment_options/show.html.twig', [
            'payment_option' => $paymentOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_options_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PaymentOptions $paymentOption): Response
    {
        $form = $this->createForm(PaymentOptionsType::class, $paymentOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_options_index', [
                'id' => $paymentOption->getId(),
            ]);
        }

        return $this->render('payment_options/edit.html.twig', [
            'payment_option' => $paymentOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_options_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PaymentOptions $paymentOption): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentOption->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paymentOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_options_index');
    }
}
