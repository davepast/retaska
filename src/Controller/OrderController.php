<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order", methods="GET|POST")
     */
    public function order(Request $request)
    {
        $result = '';

        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('telephone', IntegerType::class)
            ->add('street', TextType::class)
            ->add('city', TextType::class)
            ->add('zipCode', IntegerType::class)
            ->add('country', CountryType::class)
            ->add('delivery', ChoiceType::class, [
                'choices' => [
                    'Česká pošta - Balík do ruky' => 'czechPostParcelHand',
                    'Česká pošta - Balík na poštu' => 'czechPostParcelPost',
                    'PPL' => 'PPL',
                ]
            ])
            ->add('payment', ChoiceType::class, [
                'choices' => [
                    'Kartou online' => 'payCardOnline',
                    'Kartou při doručení' => 'payCardOnDelivery',
                    'Bankovním převodem' => 'payBankTransfer'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $name = $formData['name'];

        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'name' => $name ?? null,
            'submittedData' => $formData ?? []

        ]);
    }
}
