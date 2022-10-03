<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20221001183022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add latitude and longitude and update store entity';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE address ADD stores_id INT DEFAULT NULL, ADD latitude NUMERIC(18, 8) DEFAULT NULL, ADD longitude NUMERIC(19, 8) DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818D710F7F FOREIGN KEY (stores_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F818D710F7F ON address (stores_id)');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758775713BC80');
        $this->addSql('DROP INDEX IDX_FF5758775713BC80 ON store');
        $this->addSql('ALTER TABLE store DROP addresses_id');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818D710F7F');
        $this->addSql('DROP INDEX IDX_D4E6F818D710F7F ON address');
        $this->addSql('ALTER TABLE address DROP stores_id, DROP latitude, DROP longitude');
        $this->addSql('ALTER TABLE store ADD addresses_id INT NOT NULL');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758775713BC80 FOREIGN KEY (addresses_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FF5758775713BC80 ON store (addresses_id)');
    }
}
