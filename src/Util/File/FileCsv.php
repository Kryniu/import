<?php

declare(strict_types=1);

namespace App\Util\File;

use App\Exception\ImportFileNotExistException;

final class FileCsv extends File
{
    public const FILE_EXTENSION_CSV = '.csv';

    public function createOrAppendToFile(string $fileContent, string $fileName): void
    {
        if ($this->isFileExists($fileName, self::FILE_EXTENSION_CSV)) {
            $this->appendToFile($fileContent, $fileName, self::FILE_EXTENSION_CSV);
        } else {
            $this->createFile($fileContent, $fileName, self::FILE_EXTENSION_CSV);
        }
    }

    /**
     * @throws ImportFileNotExistException
     */
    public function getFileContentAsLines(string $fileName): array
    {
        $filePath = $this->getFilePath($fileName, self::FILE_EXTENSION_CSV);
        if (!file_exists($filePath)) {
            throw new ImportFileNotExistException($filePath);
        }
        $fileContent = file_get_contents($filePath);

        return explode(PHP_EOL, $fileContent);
    }

    public function separateRowData(string $rowData): array
    {
        $filterRowData = str_replace(["\r"], '', $rowData);

        return explode(';', $filterRowData);
    }

    public function removeFile(string $fileName): void
    {
        $filePath = $this->getFilePath($fileName, self::FILE_EXTENSION_CSV);
        parent::removeFile($filePath);
    }
}