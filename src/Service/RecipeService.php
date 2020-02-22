<?php

namespace App\Service;

use App\Service\FileService;
use App\Service\IngredientService;

class RecipeService
{
    private $fileService, $ingredientService;

    public function __construct(
        FileService $fileService,
        IngredientService $ingredientService
    )
    {
        $this->fileService = $fileService;
        $this->ingredientService = $ingredientService;
    }

    public function getAvailable()
    {
        $ingredients = $this->ingredientService->getAvailable();

        $recipes = $this->fileService->read(
            '/src/App/Recipe/data.json'
        );
        $recipes = $recipes->recipes;

        $available = [];
        for ($i = 0; $i < count($recipes); $i++) {
            $recipe = $recipes[$i];
            $recipe_ingre = $recipe->ingredients;
            $intersect = array_intersect($ingredients, $recipe_ingre);
            if (count($intersect) == count($recipe_ingre)) {
                array_push($available, $recipe);
            }
        }
        return $available;
    }
}
