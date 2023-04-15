<?php

namespace App\Controller;

use App\Repository\CharacterRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends AbstractController
{
    private $characterRepository;

    public function __construct(CharacterRepository $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }
    #[Route('/')]
    public function homePage ()
    {
        $characters = $this->characterRepository->findAll();

        return $this->render('home.html.twig', [
            'characters' => $characters
        ]);
    }
}