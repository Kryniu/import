<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210903122700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables categories, products';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(/** @lang MariaDB */ <<< SQL
            CREATE TABLE categories
            (
                id            INT AUTO_INCREMENT NOT NULL,
                name          VARCHAR(255)       NOT NULL,
                PRIMARY KEY (id)
            )
        SQL);

        $this->addSql(/** @lang MariaDB */ <<< SQL
            CREATE TABLE products
            (
                id            INT AUTO_INCREMENT NOT NULL,
                name          VARCHAR(255)       NOT NULL,
                `index`       VARCHAR(255)       NOT NULL,
                categories_id INT DEFAULT NULL,
                INDEX IDX_porducts_categoriesId (categories_id),
                CONSTRAINT UC_products_index UNIQUE (`index`),
                CONSTRAINT FK_products_categoriesId FOREIGN KEY (categories_id) REFERENCES categories (id),
                PRIMARY KEY (id)
            )
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE products');
    }
}
