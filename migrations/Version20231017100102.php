<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017100102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_departement (user_id INT NOT NULL, departement_id INT NOT NULL, INDEX IDX_686D92F6A76ED395 (user_id), INDEX IDX_686D92F6CCF9E01E (departement_id), PRIMARY KEY(user_id, departement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_departement ADD CONSTRAINT FK_686D92F6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_departement ADD CONSTRAINT FK_686D92F6CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_departement DROP FOREIGN KEY FK_686D92F6A76ED395');
        $this->addSql('ALTER TABLE user_departement DROP FOREIGN KEY FK_686D92F6CCF9E01E');
        $this->addSql('DROP TABLE user_departement');
    }
}
