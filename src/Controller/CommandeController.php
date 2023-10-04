<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Product;
use App\Form\CommandeType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'commande')]
    public function index(CartService $cart, ProductRepository $product): Response
    {

        dump($cart->getCartWithData());

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'products' => $product->findAll()
        ]);
    }

    #[Route('/acheter', name: 'acheter')]
    public function acheter(CartService $cart, EntityManagerInterface $manager, Request $request): Response
    {
        if ($this->getUser()) {
        foreach ($cart->getCartWithData() as $b => $p) {

            $commande = new Commande();

            $form = $this->createForm(CommandeType::class, $commande);
            $form->handleRequest($request);

            $commande->setUser($this->getUser());
            $commande->setProduct($p['Product']);

            $p['Product']->setDisponibility(false);


            $manager->persist($p['Product']);
            $manager->persist($commande);
        } 

        $manager->flush();
        $cart->destroy();

        return $this->redirectToRoute('app_product');
    } else {
        return $this->redirectToRoute('login');
    }
    } 
}
