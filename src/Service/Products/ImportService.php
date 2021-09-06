<?php

declare(strict_types=1);

namespace App\Service\Products;

use App\Entity\Products;
use App\Exception\ImportFileNotExistException;
use App\Util\File\FileCsv;
use App\Model\Products\ImportModel;
use App\Repository\ProductsRepository;
use Psr\Log\LoggerInterface;

final class ImportService
{
    public const FILE_NAME = 'products';

    private int $addedProductsCount = 0;

    private array $fileProductsIndex = [];

    private array $dbProducts = [];

    public function __construct(private FileCsv $fileCsv, private ProductsRepository $productsRepository, private LoggerInterface $logger)
    {
    }

    public function addFile(ImportModel $importModel): void
    {
        $this->fileCsv->createOrAppendToFile(file_get_contents($importModel->getFile()),self::FILE_NAME);
    }

    /**
     * @throws ImportFileNotExistException
     */
    public function importFromFile(): void
    {
        $fileContent = $this->fileCsv->getFileContentAsLines(self::FILE_NAME);
        $this->dbProducts = $this->productsRepository->findAllByIndex();
        foreach ($fileContent as $row) {
            $this->addProductsFromFile($row);
        }
        $this->productsRepository->save();
        $this->fileCsv->removeFile(self::FILE_NAME);
    }

    private function addProductsFromFile(string $fileRow): void
    {
        $product = $this->fileCsv->separateRowData($fileRow);
        $productName = trim($product[0] ?? '');
        $index = trim($product[1] ?? '');
        if (empty($productName) || empty($index)) {
            $this->logger->info('Product skipped! Product index or name is empty', [
                'name' => $productName,
                'index' => $index,
            ]);
            return;
        }
        if (!empty($this->fileProductsIndex[$index])) {
            $this->logger->info('Product skipped! Product index in file exist.', [
                'name' => $productName,
                'index' => $index,
            ]);
            return;
        }
        if (!empty($this->dbProducts[$index])) {
            $this->logger->info('Product skipped! Product index in database exist.', [
                'name' => $productName,
                'index' => $index,
            ]);
            return;
        }
        $products = new Products($productName, $index);
        $this->productsRepository->add($products);
        $this->fileProductsIndex[$index] = $product;
        $this->addedProductsCount++;
    }

    public function getAddedProductsCount(): int
    {
        return $this->addedProductsCount;
    }
}
