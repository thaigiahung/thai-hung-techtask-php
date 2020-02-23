<?php

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;

class FileService
{
    public function read(String $source)
    {
        $file = file_get_contents($source);
        return json_decode($file);
    }
}
