<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220927170450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'fix User entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD username VARCHAR(30) NOT NULL, CHANGE lastname lastname VARCHAR(40) DEFAULT NULL, CHANGE firstname firstname VARCHAR(40) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP username, CHANGE lastname lastname VARCHAR(30) DEFAULT NULL, CHANGE firstname firstname VARCHAR(30) DEFAULT NULL');
    }
}
