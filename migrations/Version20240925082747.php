<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925082747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lessons_user (lessons_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EA3EB798FED07355 (lessons_id), INDEX IDX_EA3EB798A76ED395 (user_id), PRIMARY KEY(lessons_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lessons_user ADD CONSTRAINT FK_EA3EB798FED07355 FOREIGN KEY (lessons_id) REFERENCES lessons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lessons_user ADD CONSTRAINT FK_EA3EB798A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lessons_user DROP FOREIGN KEY FK_EA3EB798FED07355');
        $this->addSql('ALTER TABLE lessons_user DROP FOREIGN KEY FK_EA3EB798A76ED395');
        $this->addSql('DROP TABLE lessons_user');
    }
}
