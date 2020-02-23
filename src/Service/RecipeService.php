<?php

namespace App\Service;

use App\Service\FileService;
use App\Service\IngredientService;

class RecipeService
{
    public function getAvailable(String $recipe_src, String $ingredient_src)
    {
        $ingredientService = new IngredientService();
        $ingredients = $ingredientService->getAvailable($ingredient_src);

        $fileService = new FileService();
        $recipes = $fileService->read($recipe_src);
        $recipes = $recipes->recipes;

        $available = [];
        for ($i = 0; $i < count($recipes); $i++) {
            $recipe = $recipes[$i];
            $recipe_ingre = $recipe->ingredients;

            $oldest = $this->findOldestIngredient($recipe, $ingredients['objs']);
            $recipe->oldest = $oldest->{'best-before'} ?? null;

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
