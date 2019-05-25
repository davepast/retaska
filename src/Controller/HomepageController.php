<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
                'topProducts' => $productRepository->displayTopThree(),
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
     * @Route("/list/", name="list")
     */
    public function list(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {

        return $this->render('homepage/list.html.twig', [
            'homepage'=> [
                'heading' => 'Seznam produktů'
            ],
            'products' => $productRepository->listAccToAlphabet(),
            'categories' => $categoryRepository->findAll()

        ]);
    }

    /**
     * @Route("/list/{id}", name="list_id")
     */
    public function listCategory(ProductRepository $productRepository, CategoryRepository $categoryRepository, $id)
    {
        return $this->render('homepage/list.html.twig', [
            'homepage'=> [
                'heading' => 'Seznam produktů'
            ],
            'products' => $productRepository->listAccToAlphabetByCategory($id),
                //$productRepository->findBy(['category' => $id]),
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

    /**
     * Vyhledání produktu podle parametru v URL, napriklad "/search?search=taska" (Předpokládá formulář odeslaný metodou GET).
     *
     * @Route("/search", name="search")
     */
    public function search(EntityManagerInterface $entityManager, Request $request)
    {
       /* $searchForm = $this->createFormBuilder()
            ->add('search', TextType::class, [
                'data' => 'Vyhledávání'
            ])
            ->add('send', SubmitType::class, ['label' => "Vyhledat"])
            ->getForm();

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();

            $search = $data['search'];

                //$request->query->get('search');
            $products = $entityManager
                ->createQuery("SELECT p FROM " . Product::class . " p WHERE p.name LIKE :search")
                ->setParameter('search', "%$search%")
                ->getResult();

            return $this->render('homepage/search.html.twig', [
                'homepage'=> [
                    'heading' => 'Vyhledané produkty pro termín "' . $search . '"'
                ],
                'products' => $products, // <- $products jse ve stejném tvaru, jako vrací metoda findAll()
                'searchForm' => $searchForm->createView(),
                'categories' => NULL
            ]);
        }

        return $this->render('homepage/search.html.twig', [
            'homepage'=> [
                'heading' => 'Vyhledání produktů'
            ],
            'searchForm' => $searchForm->createView(),
            'products' => NULL,
            'categories' => NULL
        ]);

       */

        $search = $request->query->get('search');
        $products = $entityManager
            ->createQuery("SELECT p FROM " . Product::class . " p WHERE p.name LIKE :search")
            ->setParameter('search', "%$search%")
            ->getResult();
        // Vygeneruje SQL: SELECT * FROM product p WHERE p.name LIKE '%taska%'
        return $this->render('homepage/search.html.twig', [
            'products' => $products,
            'searchedFor' => $search,
            'homepage'=> [
                'heading' => 'Vyhledávání produktů'
            ]
        ]);


    }
}
