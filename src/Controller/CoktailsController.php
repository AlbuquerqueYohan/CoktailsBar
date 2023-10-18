<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Form\AddCocktailType;
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


    #[Route('/coktails', name: 'cocktails')]
    public function index(): Response
    {
        $cocktails = $this->cocktailRepository->findAll();
        return $this->render('coktails/index.html.twig', [
            'cocktails' => $cocktails,
        ]);
    }

    #[Route('/coktails/add', name: 'add_cocktail')]
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

        return $this->render('coktails/addcocktail.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
