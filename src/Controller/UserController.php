<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response


    {
        return $this->render('admin/dashboard.html.twig', [
            'title' => 'Dashboard'
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pass = $hasher->hashPassword($user, $form->get('password')->getData());

            $user->setPassword($pass);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');

            $this->addFlash(
                'success',
                'Votre profil a bien été crée'
            );
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'title' => 'Enregistrement'
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {


        return $this->render(
            'user/login.html.twig',
            [
                'title' => 'Connexion'
            ]
        );
    }
}
