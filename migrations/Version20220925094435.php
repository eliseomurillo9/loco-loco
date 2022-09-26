<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220925094435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add store and address entity';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, phone_number VARCHAR(15) DEFAULT NULL, email VARCHAR(180) NOT NULL, website VARCHAR(255) DEFAULT NULL, siret_number VARCHAR(14) NOT NULL, picture VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, road_specificity LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE store');
    }
}
