<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701031944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE externo (id INT AUTO_INCREMENT NOT NULL, externo_mail VARCHAR(255) NOT NULL, externo_pass VARCHAR(255) NOT NULL, externo_admin TINYINT(1) NOT NULL, externo_activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE externo_perfil (externo_id INT NOT NULL, perfil_id INT NOT NULL, INDEX IDX_A21144A5F406A436 (externo_id), INDEX IDX_A21144A557291544 (perfil_id), PRIMARY KEY(externo_id, perfil_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE externo_perfil ADD CONSTRAINT FK_A21144A5F406A436 FOREIGN KEY (externo_id) REFERENCES externo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE externo_perfil ADD CONSTRAINT FK_A21144A557291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE externo_perfil DROP FOREIGN KEY FK_A21144A5F406A436');
        $this->addSql('DROP TABLE externo');
        $this->addSql('DROP TABLE externo_perfil');
    }
}
