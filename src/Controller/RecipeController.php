<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\RecipeService;

class RecipeController extends AbstractController
{
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }
    
    /**
     * @Route("/lunch", name="lunch")
     */
    public function lunch()
    {
        $mess = $this->recipeService->getAvailable();
        return $this->json([
            'message' => $mess
        ]);
    }
}
