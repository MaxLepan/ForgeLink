<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220191104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(511) NOT NULL, created_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, priority VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_97A0ADA3727ACA70 FOREIGN KEY (parent_id) REFERENCES ticket_parent (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3727ACA70 ON ticket (parent_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A76ED395 ON ticket (user_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:simple_array)
        )');
        $this->addSql('CREATE TEMPORARY TABLE __temp__feedback AS SELECT id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at FROM feedback');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('CREATE TABLE feedback (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, event_date DATETIME NOT NULL, location VARCHAR(255) DEFAULT NULL, environmental_conditions VARCHAR(255) DEFAULT NULL, operation_type VARCHAR(255) DEFAULT NULL, description VARCHAR(511) NOT NULL, deadline VARCHAR(255) NOT NULL, suggested_solution VARCHAR(511) DEFAULT NULL, is_new BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO feedback (id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at) SELECT id, title, event_date, location, environmental_conditions, operation_type, description, deadline, suggested_solution, is_new, created_at FROM __temp__feedback');
        $this->addSql('DROP TABLE __temp__feedback');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__feedback AS SELECT id, title, description, created_at, event_date, location, environmental_conditions, operation_type, deadline, suggested_solution, is_new FROM feedback');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('CREATE TABLE feedback (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(511) NOT NULL, created_at VARCHAR(255) DEFAULT \'datetime(now, YYYY-MM-DD HH:MM:SS)\' NOT NULL, event_date DATETIME NOT NULL, location VARCHAR(255) DEFAULT NULL, environmental_conditions VARCHAR(255) DEFAULT NULL, operation_type VARCHAR(255) DEFAULT NULL, deadline VARCHAR(255) NOT NULL, suggested_solution VARCHAR(511) DEFAULT NULL, is_new BOOLEAN DEFAULT 1 NOT NULL)');
        $this->addSql('INSERT INTO feedback (id, title, description, created_at, event_date, location, environmental_conditions, operation_type, deadline, suggested_solution, is_new) SELECT id, title, description, created_at, event_date, location, environmental_conditions, operation_type, deadline, suggested_solution, is_new FROM __temp__feedback');
        $this->addSql('DROP TABLE __temp__feedback');
    }
}
