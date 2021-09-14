<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913135649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apto (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingrediente (id INT AUTO_INCREMENT NOT NULL, unidad_id INT DEFAULT NULL, descripcion VARCHAR(255) DEFAULT NULL, INDEX IDX_BFB4A41E9D01464C (unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, fecha DATE DEFAULT NULL, INDEX IDX_B093494EDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta_apto (receta_id INT NOT NULL, apto_id INT NOT NULL, INDEX IDX_271BCE8454F853F8 (receta_id), INDEX IDX_271BCE844D982896 (apto_id), PRIMARY KEY(receta_id, apto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta_ingrediente (id INT AUTO_INCREMENT NOT NULL, receta_id INT DEFAULT NULL, ingrediente_id INT DEFAULT NULL, cantidad NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_F7A6A61354F853F8 (receta_id), INDEX IDX_F7A6A613769E458D (ingrediente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_apto (user_id INT NOT NULL, apto_id INT NOT NULL, INDEX IDX_1AF0ABD8A76ED395 (user_id), INDEX IDX_1AF0ABD84D982896 (apto_id), PRIMARY KEY(user_id, apto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_receta (user_id INT NOT NULL, receta_id INT NOT NULL, INDEX IDX_D5C15273A76ED395 (user_id), INDEX IDX_D5C1527354F853F8 (receta_id), PRIMARY KEY(user_id, receta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_ingrediente (user_id INT NOT NULL, ingrediente_id INT NOT NULL, INDEX IDX_16AF6D8BA76ED395 (user_id), INDEX IDX_16AF6D8B769E458D (ingrediente_id), PRIMARY KEY(user_id, ingrediente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingrediente ADD CONSTRAINT FK_BFB4A41E9D01464C FOREIGN KEY (unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE receta ADD CONSTRAINT FK_B093494EDB38439E FOREIGN KEY (usuario_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE receta_apto ADD CONSTRAINT FK_271BCE8454F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receta_apto ADD CONSTRAINT FK_271BCE844D982896 FOREIGN KEY (apto_id) REFERENCES apto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receta_ingrediente ADD CONSTRAINT FK_F7A6A61354F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE receta_ingrediente ADD CONSTRAINT FK_F7A6A613769E458D FOREIGN KEY (ingrediente_id) REFERENCES ingrediente (id)');
        $this->addSql('ALTER TABLE user_apto ADD CONSTRAINT FK_1AF0ABD8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_apto ADD CONSTRAINT FK_1AF0ABD84D982896 FOREIGN KEY (apto_id) REFERENCES apto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_receta ADD CONSTRAINT FK_D5C15273A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_receta ADD CONSTRAINT FK_D5C1527354F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ingrediente ADD CONSTRAINT FK_16AF6D8BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ingrediente ADD CONSTRAINT FK_16AF6D8B769E458D FOREIGN KEY (ingrediente_id) REFERENCES ingrediente (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receta_apto DROP FOREIGN KEY FK_271BCE844D982896');
        $this->addSql('ALTER TABLE user_apto DROP FOREIGN KEY FK_1AF0ABD84D982896');
        $this->addSql('ALTER TABLE receta_ingrediente DROP FOREIGN KEY FK_F7A6A613769E458D');
        $this->addSql('ALTER TABLE user_ingrediente DROP FOREIGN KEY FK_16AF6D8B769E458D');
        $this->addSql('ALTER TABLE receta_apto DROP FOREIGN KEY FK_271BCE8454F853F8');
        $this->addSql('ALTER TABLE receta_ingrediente DROP FOREIGN KEY FK_F7A6A61354F853F8');
        $this->addSql('ALTER TABLE user_receta DROP FOREIGN KEY FK_D5C1527354F853F8');
        $this->addSql('ALTER TABLE ingrediente DROP FOREIGN KEY FK_BFB4A41E9D01464C');
        $this->addSql('DROP TABLE apto');
        $this->addSql('DROP TABLE ingrediente');
        $this->addSql('DROP TABLE receta');
        $this->addSql('DROP TABLE receta_apto');
        $this->addSql('DROP TABLE receta_ingrediente');
        $this->addSql('DROP TABLE unidad');
        $this->addSql('DROP TABLE user_apto');
        $this->addSql('DROP TABLE user_receta');
        $this->addSql('DROP TABLE user_ingrediente');
    }
}
