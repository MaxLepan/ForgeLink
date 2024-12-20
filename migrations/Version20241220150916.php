<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220150916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__feedback AS SELECT id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at FROM feedback');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('CREATE TABLE feedback (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, event_date DATETIME NOT NULL, location VARCHAR(255) DEFAULT NULL, environmental_conditions VARCHAR(255) DEFAULT NULL, operation_type VARCHAR(255) DEFAULT NULL, description VARCHAR(511) NOT NULL, deadline VARCHAR(255) NOT NULL, suggested_solution VARCHAR(511) DEFAULT NULL, is_new BOOLEAN DEFAULT 1 NOT NULL, created_at VARCHAR(255) DEFAULT \'datetime(now, YYYY-MM-DD HH:MM:SS)\' NOT NULL)');
        $this->addSql('INSERT INTO feedback (id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at) SELECT id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at FROM __temp__feedback');
        $this->addSql('DROP TABLE __temp__feedback');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__feedback AS SELECT id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at FROM feedback');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('CREATE TABLE feedback (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, event_date DATETIME NOT NULL, location VARCHAR(255) DEFAULT NULL, environmental_conditions VARCHAR(255) DEFAULT NULL, operation_type VARCHAR(255) DEFAULT NULL, description VARCHAR(511) NOT NULL, deadline VARCHAR(255) NOT NULL, suggested_solution VARCHAR(511) DEFAULT NULL, is_new BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO feedback (id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at) SELECT id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at FROM __temp__feedback');
        $this->addSql('DROP TABLE __temp__feedback');
    }
}
