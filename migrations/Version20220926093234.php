<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220926093234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add store_opening_hours and store relations';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE store_product (store_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CA42254AB092A811 (store_id), INDEX IDX_CA42254A4584665A (product_id), PRIMARY KEY(store_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store_user (store_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6F2A7887B092A811 (store_id), INDEX IDX_6F2A7887A76ED395 (user_id), PRIMARY KEY(store_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store_hours (id INT AUTO_INCREMENT NOT NULL, store_id INT NOT NULL, day INT NOT NULL, morning_opening_time TIME DEFAULT NULL, morning_closing_time TIME DEFAULT NULL, afternoon_opening_time TIME DEFAULT NULL, afternoon_closing_time TIME DEFAULT NULL, INDEX IDX_F624EB94B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE store_product ADD CONSTRAINT FK_CA42254AB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_product ADD CONSTRAINT FK_CA42254A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_user ADD CONSTRAINT FK_6F2A7887B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_user ADD CONSTRAINT FK_6F2A7887A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_hours ADD CONSTRAINT FK_F624EB94B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE store ADD addresses_id INT NOT NULL');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758775713BC80 FOREIGN KEY (addresses_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_FF5758775713BC80 ON store (addresses_id)');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE store_product DROP FOREIGN KEY FK_CA42254AB092A811');
        $this->addSql('ALTER TABLE store_product DROP FOREIGN KEY FK_CA42254A4584665A');
        $this->addSql('ALTER TABLE store_user DROP FOREIGN KEY FK_6F2A7887B092A811');
        $this->addSql('ALTER TABLE store_user DROP FOREIGN KEY FK_6F2A7887A76ED395');
        $this->addSql('ALTER TABLE store_hours DROP FOREIGN KEY FK_F624EB94B092A811');
        $this->addSql('DROP TABLE store_product');
        $this->addSql('DROP TABLE store_user');
        $this->addSql('DROP TABLE store_hours');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758775713BC80');
        $this->addSql('DROP INDEX IDX_FF5758775713BC80 ON store');
        $this->addSql('ALTER TABLE store DROP addresses_id');
    }
}
