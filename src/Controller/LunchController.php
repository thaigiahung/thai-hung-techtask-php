<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\RecipeService;

class LunchController extends AbstractController
{
    /**
     * @Route("/lunch", name="lunch")
     */
    public function getLunch()
    {
        $root = dirname(dirname(dirname(__FILE__)));
        $ingredient_src = $root . $_ENV['INGREDIENT_DATA'];
        $recipe_src = $root . $_ENV['RECIPE_DATA'];

        $recipeService = new RecipeService();
        $recipes = $recipeService->getAvailable($recipe_src, $ingredient_src);
        return $this->json($recipes);
    }
}
