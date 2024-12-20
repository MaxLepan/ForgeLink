<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221134913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedback (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, event_date DATETIME NOT NULL, location VARCHAR(255) DEFAULT NULL, environmental_conditions VARCHAR(255) DEFAULT NULL, operation_type VARCHAR(255) DEFAULT NULL, description VARCHAR(511) NOT NULL, deadline VARCHAR(255) NOT NULL, suggested_solution VARCHAR(511) DEFAULT NULL, is_new BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_D2294458166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D2294458166D1F9C ON feedback (project_id)');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(511) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE project_user (project_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(project_id, user_id), CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B4021E51166D1F9C ON project_user (project_id)');
        $this->addSql('CREATE INDEX IDX_B4021E51A76ED395 ON project_user (user_id)');
        $this->addSql('CREATE TABLE super_ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_feedback_id INTEGER NOT NULL, assignee_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, priority VARCHAR(255) NOT NULL, description VARCHAR(511) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deadline VARCHAR(255) NOT NULL, CONSTRAINT FK_5A43291AB965BAF7 FOREIGN KEY (parent_feedback_id) REFERENCES feedback (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5A43291A59EC7D60 FOREIGN KEY (assignee_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5A43291AB965BAF7 ON super_ticket (parent_feedback_id)');
        $this->addSql('CREATE INDEX IDX_5A43291A59EC7D60 ON super_ticket (assignee_id)');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, parent_superticket_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, priority VARCHAR(255) NOT NULL, description VARCHAR(511) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_97A0ADA39FCFE992 FOREIGN KEY (parent_superticket_id) REFERENCES super_ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A76ED395 ON ticket (user_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA39FCFE992 ON ticket (parent_superticket_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, display_name VARCHAR(255) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:simple_array)
        )');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE super_ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
