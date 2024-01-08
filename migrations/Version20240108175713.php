<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108175713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workload ADD worker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workload ADD project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workload ADD CONSTRAINT FK_1203AA7B6B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workload ADD CONSTRAINT FK_1203AA7B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1203AA7B6B20BA36 ON workload (worker_id)');
        $this->addSql('CREATE INDEX IDX_1203AA7B166D1F9C ON workload (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE workload DROP CONSTRAINT FK_1203AA7B6B20BA36');
        $this->addSql('ALTER TABLE workload DROP CONSTRAINT FK_1203AA7B166D1F9C');
        $this->addSql('DROP INDEX IDX_1203AA7B6B20BA36');
        $this->addSql('DROP INDEX IDX_1203AA7B166D1F9C');
        $this->addSql('ALTER TABLE workload DROP worker_id');
        $this->addSql('ALTER TABLE workload DROP project_id');
    }
}
