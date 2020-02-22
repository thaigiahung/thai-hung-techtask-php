<?php

namespace App\Service;

use App\Service\FileService;

class IngredientService
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getAvailable()
    {
        $ingredients = $this->fileService->read(
            '/src/App/Ingredient/data.json'
        );
        $ingredients = $ingredients->ingredients;
        $today = date('Y-m-d');
        $available = [];
        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $ingredients[$i];
            if ($today <= $ingredient->{'use-by'}) {
                array_push($available, $ingredient->title);
            }
        }
        return $available;
    }
}
