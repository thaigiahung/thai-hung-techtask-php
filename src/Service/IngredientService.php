<?php

namespace App\Service;

use App\Service\FileService;
use stdClass;

class IngredientService
{
    /**
     * Get available ingredients
     *
     * @param string $source File path of the ingredients json data
     *
     * @return array An array which contain:
     *                  - titles: a list of titles only
     *                  - objs: store full ingredient data
     */
    public function getAvailable($source)
    {
        $fileService = new FileService();
        $ingredients = $fileService->read($source);
        $ingredients = $ingredients->ingredients;
        $today = date('Y-m-d');
        $available = [
            'titles' => [],
            'objs' => new stdClass
        ];
        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $ingredients[$i];
            if ($today <= $ingredient->{'use-by'}) {
                array_push($available['titles'], $ingredient->title);
                $available['objs']->{$ingredient->title} = $ingredient;
            }
        }
        return $available;
    }
}
