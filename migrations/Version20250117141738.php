<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117141738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_groups_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('CREATE TABLE student_groups (id INT NOT NULL, faculty_id INT DEFAULT NULL, group_leader_id INT DEFAULT NULL, education_plan_id INT DEFAULT NULL, name VARCHAR(12) NOT NULL, code VARCHAR(255) DEFAULT NULL, date_start DATE DEFAULT NULL, data_end DATE DEFAULT NULL, course_number INT DEFAULT NULL, parallel_number INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E5BE1F0680CAB68 ON student_groups (faculty_id)');
        $this->addSql('CREATE INDEX IDX_7E5BE1F0B3A61235 ON student_groups (group_leader_id)');
        $this->addSql('CREATE INDEX IDX_7E5BE1F0F4BD6D43 ON student_groups (education_plan_id)');
        $this->addSql('ALTER TABLE student_groups ADD CONSTRAINT FK_7E5BE1F0680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_groups ADD CONSTRAINT FK_7E5BE1F0B3A61235 FOREIGN KEY (group_leader_id) REFERENCES staff (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_groups ADD CONSTRAINT FK_7E5BE1F0F4BD6D43 FOREIGN KEY (education_plan_id) REFERENCES education_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_groups_id_seq CASCADE');
        $this->addSql('ALTER TABLE student_groups DROP CONSTRAINT FK_7E5BE1F0680CAB68');
        $this->addSql('ALTER TABLE student_groups DROP CONSTRAINT FK_7E5BE1F0B3A61235');
        $this->addSql('ALTER TABLE student_groups DROP CONSTRAINT FK_7E5BE1F0F4BD6D43');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE student_groups');
    }
}
