<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    #[Route('/', name: 'redirection')]
    public function index(ProductRepository $productRepository, CartService $cart): Response
    {
        $products = $productRepository->findAll();

        dump($cart->getCartWithData());



        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
            'carts' => $cart->getCartWithData()
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(EntityManagerInterface $manager, HttpFoundationRequest $request): Response
    {

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('picture_src')->getData();
            $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();

            $file->move($this->getParameter('upload_dir'), $file_name);

            $product->setPictureSrc($file_name);

            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('app_product');
        }


        return $this->render(
            'product/ajouter.html.twig',
            [
                'form' => $form->createView(),
                'title' => 'Ajout d\'oeuvres'
            ]
        );
    }

    #[Route('/categories', name: 'categories')]
    public function categories(EntityManagerInterface $manager, HttpFoundationRequest $request): Response
    {

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('categories');
        }



        return $this->render(
            'product/categories.html.twig',
            [
                'form' => $form->createView(),
                'title' => 'Ajout de catégories'
            ]
        );
    }

    #[Route('/destroy', name: 'destroy')]
    public function destroy(CartService $cartService): Response
    {

        $cartService->destroy();


        return $this->redirectToRoute('redirection');
    }

    #[Route('/add/{id}', name: 'add')]
    public function add_panier(CartService $cartService, $id): Response
    {
        $cartService->add($id);
        $this->addFlash('info', 'Ajouté au panier');
        return $this->redirectToRoute('redirection');
    }

    // #[Route('/remove/{id}', name: 'remove')]
    // public function remove_panier(CartService $cartService, $id): Response
    // {


    //     $cartService->remove($id);
    //     $this->addFlash('info', 'Retiré du panier');
    //     return $this->redirectToRoute('redirection');
    // }
}
