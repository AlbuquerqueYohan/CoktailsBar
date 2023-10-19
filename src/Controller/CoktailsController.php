<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Form\AddCocktailType;
use App\Form\CocktailType;
use App\Repository\CocktailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoktailsController extends AbstractController
{

    private $cocktailRepository;

    private $em;

    public function __construct(CocktailRepository $cocktailRepository, EntityManagerInterface $em)
    {
        $this->cocktailRepository = $cocktailRepository;
        $this->em = $em;
    }


    #[Route('/cocktails', name: 'cocktails')]
    public function index(): Response
    {
        $cocktails = $this->cocktailRepository->findAll();
        return $this->render('cocktails/index.html.twig', [
            'cocktails' => $cocktails,
        ]);
    }

    #[Route('/cocktails/add', name: 'add_cocktail')]
    public function add(Request $request): Response
    {
        $cocktail = new Cocktail();
        $form = $this->createForm(AddCocktailType::class, $cocktail);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $cocktail->setCreatedAt(new \DateTimeImmutable());
            $cocktail->setUpdatedAt(new \DateTimeImmutable());

            $this->em->persist($cocktail);

            $this->em->flush();

            return $this->redirectToRoute('cocktails');
        }

        return $this->render('cocktails/addcocktail.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cocktails/update/{id}', name: 'update_cocktail')]
    public function update(int $id, Cocktail $cocktail, Request $request): Response
    {
        $form = $this->createForm(CocktailType::class, $cocktail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cocktail->setUpdatedAt(new \DateTimeImmutable());
            $this->em->flush();

            return $this->redirectToRoute('cocktails');
        }

        return $this->render('cocktails/updatecocktail.html.twig', [
            'cocktail' => $cocktail,
            'form' => $form,
        ]);
    }

    #[Route('/cocktails/delete/{id}', name: 'delete_cocktail')]
    public function delete(int $id, Cocktail $cocktail): Response
    {
        $this->em->remove($cocktail);
        $this->em->flush();

        return $this->redirectToRoute('cocktails');
    }

}
