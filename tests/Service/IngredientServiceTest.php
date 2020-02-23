<?php

namespace App\Tests\Service;

use App\Service\IngredientService;
use PHPUnit\Framework\TestCase;

class IngredientServiceTest extends TestCase
{
    public function testGetAvailable()
    {
        $ingredientService = new IngredientService();
        $root = dirname(dirname(dirname(__FILE__)));
        $source = $root . $_ENV['INGREDIENT_DATA'];

        $ingredients = $ingredientService->getAvailable($source);
        $this->assertNotContains('Ham', $ingredients['titles']);
    }
}
