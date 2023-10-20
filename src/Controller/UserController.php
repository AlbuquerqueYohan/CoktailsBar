<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use App\Form\LoginClientType;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/add', name: 'add_user')]
    public function add(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(AddUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $this->em->persist($user);

            $this->em->flush();

            return $this->redirectToRoute('add_user');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/list', name: 'list_user')]
    public function listUser()
    {
        $users = $this->userRepository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/update/{id}', name: 'update_user')]
    public function update(int $id, User $user, Request $request): Response
    {
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUpdatedAt(new \DateTimeImmutable());
            $this->em->flush();

            return $this->redirectToRoute('cocktails');
        }

        return $this->render('user/updateuser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/delete/{id}', name: 'delete_user')]
    public function delete(int $id, User $user): Response
    {
        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute('cocktails');
    }

}
