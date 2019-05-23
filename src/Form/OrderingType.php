<?php

namespace App\Form;

use App\Entity\CountryOptions;
use App\Entity\DeliveryOptions;
use App\Entity\Ordering;
use App\Entity\PaymentOptions;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class OrderingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Jméno'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Emailová adresa'
            ])
            ->add('telephone', NumberType::class, [
                'label' => 'Telefon'
            ])
            ->add('addressStreet', TextType::class, [
                'label' => 'Ulice a číslo domu'
            ])
            ->add('addressCity', TextType::class, [
                'label' => 'Město'
            ])
            ->add('addressZip', NumberType::class, [
                'label' => 'PSČ'
            ])
            ->add('addressCountry', EntityType::class, [
                'class' => CountryOptions::class,
                'label' => 'Země',
                'choice_label' => 'description'
            ])
            ->add('delivery', EntityType::class, [
                'class' => DeliveryOptions::class,
                'label' => 'Doručení',
                'choice_label' => 'description',
                'choice_attr' => function(DeliveryOptions $deliveryOptions) {
                    return ['data-delivery' => $deliveryOptions->getPrice()];
            }
            ])
            ->add('payment', EntityType::class, [
                'class' => PaymentOptions::class,
                'label' => 'Platba',
                'choice_label' => 'description',
                'choice_attr' => function(PaymentOptions $paymentOptions) {
                    return ['data-payment' => $paymentOptions->getPrice()]
                        ;
            }
            ])
            ->add('notes', TextType::class, [
                'label' => 'Poznámka'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'nová objednávka' => 'new',
                    'potvrzená objednávka' => 'confirmed',
                    'odeslaná objednávka' => 'sent',
                    'zrušená objednávka' => 'canceled'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ordering::class,
        ]);
    }
}
