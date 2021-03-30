<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328100140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create postcode table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE postcode (id INT AUTO_INCREMENT NOT NULL, postcode VARCHAR(10) NOT NULL, easting INT NOT NULL, northing INT NOT NULL, latitude NUMERIC(10, 3) NOT NULL, longitude NUMERIC(10, 3) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE postcode');
    }
}
