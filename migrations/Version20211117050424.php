<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117050424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial database';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE drone (serial VARCHAR(100) NOT NULL, model_id INTEGER NOT NULL, state_id INTEGER NOT NULL, weight DOUBLE PRECISION NOT NULL, battery INTEGER NOT NULL, PRIMARY KEY(serial))');
        $this->addSql('CREATE INDEX IDX_EE8B11647975B7E7 ON drone (model_id)');
        $this->addSql('CREATE INDEX IDX_EE8B11645D83CC1 ON drone (state_id)');
        $this->addSql('CREATE TABLE drone_medication (drone_serial VARCHAR(100) NOT NULL, medication_id INTEGER NOT NULL, PRIMARY KEY(drone_serial, medication_id))');
        $this->addSql('CREATE INDEX IDX_639E0DA56DA2201F ON drone_medication (drone_serial)');
        $this->addSql('CREATE INDEX IDX_639E0DA52C4DE6DA ON drone_medication (medication_id)');
        $this->addSql('CREATE TABLE drone_model (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, model VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE drone_state (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, state VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE medication (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, weight DOUBLE PRECISION NOT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE drone');
        $this->addSql('DROP TABLE drone_medication');
        $this->addSql('DROP TABLE drone_model');
        $this->addSql('DROP TABLE drone_state');
        $this->addSql('DROP TABLE medication');
    }
}
