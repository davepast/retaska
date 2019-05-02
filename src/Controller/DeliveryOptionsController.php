<?php

namespace App\Controller;

use App\Entity\DeliveryOptions;
use App\Form\DeliveryOptionsType;
use App\Repository\DeliveryOptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/delivery")
 */
class DeliveryOptionsController extends AbstractController
{
    /**
     * @Route("/", name="delivery_options_index", methods={"GET"})
     */
    public function index(DeliveryOptionsRepository $deliveryOptionsRepository): Response
    {
        return $this->render('delivery_options/index.html.twig', [
            'delivery_options' => $deliveryOptionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="delivery_options_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $deliveryOption = new DeliveryOptions();
        $form = $this->createForm(DeliveryOptionsType::class, $deliveryOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($deliveryOption);
            $entityManager->flush();

            return $this->redirectToRoute('delivery_options_index');
        }

        return $this->render('delivery_options/new.html.twig', [
            'delivery_option' => $deliveryOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_options_show", methods={"GET"})
     */
    public function show(DeliveryOptions $deliveryOption): Response
    {
        return $this->render('delivery_options/show.html.twig', [
            'delivery_option' => $deliveryOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="delivery_options_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DeliveryOptions $deliveryOption): Response
    {
        $form = $this->createForm(DeliveryOptionsType::class, $deliveryOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_options_index', [
                'id' => $deliveryOption->getId(),
            ]);
        }

        return $this->render('delivery_options/edit.html.twig', [
            'delivery_option' => $deliveryOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_options_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DeliveryOptions $deliveryOption): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deliveryOption->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($deliveryOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('delivery_options_index');
    }
}
