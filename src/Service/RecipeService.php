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

            $oldest = $this->findOldestIngredient($recipe, $ingredients['objs']);
            $recipe->oldest = $oldest->{'best-before'};

            $intersect = array_intersect($ingredients['titles'], $recipe_ingre);
            if (count($intersect) == count($recipe_ingre)) {
                array_push($available, $recipe);
            }
        }
        usort($available, function($first, $second) {
            return $first->oldest < $second->oldest;
        });
        return $available;
    }

    public function findOldestIngredient(Object $recipe, Object $ingredients)
    {
        $arr = [];
        foreach ($recipe->ingredients as $ingredient) {
            if (isset($ingredients->$ingredient)) {
                array_push($arr, $ingredients->$ingredient);
            }
        }

        usort($arr, function($first, $second) {
            return $first->{'best-before'} > $second->{'best-before'};
        });
        return $arr[0] ?? null;
    }
}
