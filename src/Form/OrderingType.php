<?php

namespace App\Form;

use App\Entity\CountryOptions;
use App\Entity\DeliveryOptions;
use App\Entity\Ordering;
use App\Entity\PaymentOptions;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('telephone')
            ->add('name')
            ->add('addressStreet')
            ->add('addressCity')
            ->add('addressZip')
            ->add('notes')
            ->add('addressCountry', EntityType::class, [
                'class' => CountryOptions::class,
                'choice_label' => 'description'
            ])
            ->add('delivery', EntityType::class, [
                'class' => DeliveryOptions::class,
                'choice_label' => 'description',
                'choice_attr' => function(DeliveryOptions $deliveryOptions) {
                    return ['data-delivery' => $deliveryOptions->getPrice()];
            }
            ])
            ->add('payment', EntityType::class, [
                'class' => PaymentOptions::class,
                'choice_label' => 'description',
                'choice_attr' => function(PaymentOptions $paymentOptions) {
                    return ['data-payment' => $paymentOptions->getPrice()]
                        ;
            }
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
