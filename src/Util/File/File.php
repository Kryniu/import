<?php

declare(strict_types=1);

namespace App\Util\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;


class File
{
    public function __construct(private Filesystem $filesystem, private KernelInterface $kernel)
    {

    }

    public function createFile(string $fileContent, string $fileName, string $fileExtension): void
    {
        $filePath = $this->getFilePath($fileName, $fileExtension);
        $this->filesystem->dumpFile($filePath, $fileContent);
    }

    public function appendToFile(string $fileContent, string $fileName, string $fileExtension): void
    {
        $filePath = $this->getFilePath($fileName, $fileExtension);
        $this->filesystem->appendToFile($filePath, PHP_EOL);
        $this->filesystem->appendToFile($filePath, $fileContent);
    }

    public function isFileExists(string $fileName, string $fileExtension): bool
    {
        return $this->filesystem->exists($this->getFilePath($fileName, $fileExtension));
    }

    public function removeFile(string $filePath): void
    {
        $this->filesystem->remove($filePath);
    }

    protected function getFilePath(string $fileName, string $fileExtension): string
    {
        return $this->kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . $fileName . $fileExtension;
    }
}
