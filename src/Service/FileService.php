<?php

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;

class FileService
{
    private $projectDir;

    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    public function read(String $filePath)
    {
        $file = file_get_contents($this->projectDir.$filePath);
        return json_decode($file);
    }
}