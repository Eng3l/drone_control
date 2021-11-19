<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119181549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Audit logs';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE battery_log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, timestamp DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE log_entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, drone_id VARCHAR(100) NOT NULL, log_id INTEGER NOT NULL, battery INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B5F762D2CDF9A ON log_entry (drone_id)');
        $this->addSql('CREATE INDEX IDX_B5F762DEA675D86 ON log_entry (log_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE battery_log');
        $this->addSql('DROP TABLE log_entry');
        $this->addSql('DROP INDEX IDX_B5F762D2CDF9A');
        $this->addSql('DROP INDEX IDX_B5F762DEA675D86');
    }
}
