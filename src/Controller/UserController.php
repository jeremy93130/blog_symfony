<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $plaintextPassword = $user->getPassword();

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            // Hasher le mot de passe avant de l'enregistrer
            $user->setPassword($hashedPassword);
            $user->setRoles();
            $entityManager->persist($user);
            $entityManager->flush();



            return new RedirectResponse($this->generateUrl('app_home'));
        }


        return $this->render('user/user.html.twig', [
            'controller_name' => 'Inscription :',
            'user' => $form->createView()
        ]);
    }
}