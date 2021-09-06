<?php

declare(strict_types=1);

namespace App\Model\Products;

final class ImportModel
{
    private ?string $file;

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): void
    {
        $this->file = $file;
    }
}
