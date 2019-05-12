<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $productRepository)
    {
        return $this->render('homepage/index.html.twig', [
            'homepage'=> [
                'heading' => 'Eshop reTaška.cz'
            ],
                'topProducts' => $productRepository->displayTopThree()
        ]);
    }

    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function admin()
    {
        return $this->render('homepage/admin.html.twig', [
            'homepage'=> [
                'heading' => 'Administrace'
            ]
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('homepage/contact.html.twig', [
            'homepage'=> [
                'heading' => 'Kontakt'
            ]
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('homepage/list.html.twig', [
            'homepage'=> [
                'heading' => 'Seznam produktů'
            ],
            'products' => $productRepository->findAll(),
            'categories' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(Product $product)
    {
        return $this->render('homepage/detail.html.twig', [
            'homepage'=> [
                'heading' => 'Detail produktu'
            ],
            'product' => $product
        ]);
    }

    /**
     * @Route("/thankyou", name="thankyou")
     */
    public function thankyou()
    {
        return $this->render('homepage/thankyou.html.twig', [
            'homepage'=> [
                'heading' => 'Děkujeme za objednávku'
            ]
        ]);
    }
}
