<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;

final class ImportFileNotExistException extends Exception
{
    public function __construct(string $filePath)
    {
        parent::__construct("File {$filePath} not exist");
    }
}
