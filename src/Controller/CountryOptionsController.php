<?php

namespace App\Controller;

use App\Entity\CountryOptions;
use App\Form\CountryOptionsType;
use App\Repository\CountryOptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/country")
 */
class CountryOptionsController extends AbstractController
{
    /**
     * @Route("/", name="country_options_index", methods={"GET"})
     */
    public function index(CountryOptionsRepository $countryOptionsRepository): Response
    {
        return $this->render('country_options/index.html.twig', [
            'country_options' => $countryOptionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="country_options_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $countryOption = new CountryOptions();
        $form = $this->createForm(CountryOptionsType::class, $countryOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($countryOption);
            $entityManager->flush();

            return $this->redirectToRoute('country_options_index');
        }

        return $this->render('country_options/new.html.twig', [
            'country_option' => $countryOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="country_options_show", methods={"GET"})
     */
    public function show(CountryOptions $countryOption): Response
    {
        return $this->render('country_options/show.html.twig', [
            'country_option' => $countryOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="country_options_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CountryOptions $countryOption): Response
    {
        $form = $this->createForm(CountryOptionsType::class, $countryOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('country_options_index', [
                'id' => $countryOption->getId(),
            ]);
        }

        return $this->render('country_options/edit.html.twig', [
            'country_option' => $countryOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="country_options_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CountryOptions $countryOption): Response
    {
        if ($this->isCsrfTokenValid('delete'.$countryOption->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($countryOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('country_options_index');
    }
}
