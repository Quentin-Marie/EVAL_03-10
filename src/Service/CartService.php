<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{

    private $repository;

    private $session;

    public function __construct(ProductRepository $ProductRepository, RequestStack $requestStack)
    {
        $this->repository = $ProductRepository;

        $this->session = $requestStack;
    }


    public function add($id)
    {
        $local = $this->session->getSession();
        $cart = $local->get('cart', []);

            $cart[$id] = $id;

        $local->set('cart', $cart);
    }

    // public function remove($id)
    // {
    //     $local = $this->session->getSession();
    //     $cart = $local->get('cart', []);
    //     if (isset($cart[$id]) && $cart[$id] == 1) {
    //         unset($cart[$id]);
    //     }

    //     $local->set('cart', $cart);
    // }

    public function destroy()
    {
        $local = $this->session->getSession();
        $local->remove('cart');
    }

    public function getCartWithData()
    {
        $local = $this->session->getSession();
        $cart = $local->get('cart', []);

        $cartWithData = [];
        foreach ($cart as $id) {
            $cartWithData[] = [

                'Product' => $this->repository->find($id),

            ];
        }
        return $cartWithData;
    }
}
