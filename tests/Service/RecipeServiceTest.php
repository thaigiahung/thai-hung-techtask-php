<?php

namespace App\Tests\Service;

use App\Service\RecipeService;
use PHPUnit\Framework\TestCase;
use stdClass;

class RecipeServiceTest extends TestCase
{
    public function testGetAvailable()
    {
        $recipeService = new RecipeService();
        $root = dirname(dirname(dirname(__FILE__)));
        $ingredient_src = $root . $_ENV['INGREDIENT_DATA'];
        $recipe_src = $root . $_ENV['RECIPE_DATA'];

        $recipes = $recipeService->getAvailable($recipe_src, $ingredient_src);
        $this->assertEquals(2, count($recipes));
        $this->assertEquals('Salad', $recipes[0]->title);
        $this->assertEquals('Hotdog', $recipes[1]->title);
    }

    public function testFindOldestIngredientWhereIngredientNotFound()
    {
        $recipe = new stdClass;
        $recipe->title = 'Recipe 1';
        $recipe->ingredients = ['I1', 'I2'];

        $ingredients = new stdClass;

        $title = 'Ingridient 1';
        $ingredient = new stdClass;
        $ingredient->title = $title;
        $ingredient->{'best-before'} = '2020-02-20';
        $ingredient->{'use-by'} = '2020-02-10';
        $ingredients->{$title} = $ingredient;

        $recipeService = new RecipeService();
        $oldest = $recipeService->findOldestIngredient($recipe, $ingredients);
        $this->assertNull($oldest);
    }

    public function testFindOldestIngredient()
    {
        $recipe = new stdClass;
        $recipe->title = 'Recipe 1';
        $recipe->ingredients = ['I1', 'I2'];

        $ingredients = new stdClass;

        $title = 'I1';
        $ingredient = new stdClass;
        $ingredient->title = 'I1';
        $ingredient->{'best-before'} = '2020-03-20';
        $ingredient->{'use-by'} = '2020-03-30';
        $ingredients->{$title} = $ingredient;

        $title = 'I2';
        $ingredient = new stdClass;
        $ingredient->title = $title;
        $ingredient->{'best-before'} = '2020-02-01';
        $ingredient->{'use-by'} = '2020-02-10';
        $ingredients->{$title} = $ingredient;

        $recipeService = new RecipeService();
        $oldest = $recipeService->findOldestIngredient($recipe, $ingredients);
        $this->assertEquals('I2', $oldest->title);
    }
}
