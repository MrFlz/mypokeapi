<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810213100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ability (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, is_hidden TINYINT(1) NOT NULL, slot INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, height INT NOT NULL, weight INT NOT NULL, base_experience INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_ability (pokemon_id INT NOT NULL, ability_id INT NOT NULL, INDEX IDX_59A592AD2FE71C3E (pokemon_id), INDEX IDX_59A592AD8016D8B2 (ability_id), PRIMARY KEY(pokemon_id, ability_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_stat (pokemon_id INT NOT NULL, stat_id INT NOT NULL, INDEX IDX_1C1181622FE71C3E (pokemon_id), INDEX IDX_1C1181629502F0B (stat_id), PRIMARY KEY(pokemon_id, stat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_type (pokemon_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_B077296A2FE71C3E (pokemon_id), INDEX IDX_B077296AC54C8C93 (type_id), PRIMARY KEY(pokemon_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, base_stat INT NOT NULL, effort INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slot INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokemon_ability ADD CONSTRAINT FK_59A592AD2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_ability ADD CONSTRAINT FK_59A592AD8016D8B2 FOREIGN KEY (ability_id) REFERENCES ability (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_stat ADD CONSTRAINT FK_1C1181622FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_stat ADD CONSTRAINT FK_1C1181629502F0B FOREIGN KEY (stat_id) REFERENCES stat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296A2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon_ability DROP FOREIGN KEY FK_59A592AD2FE71C3E');
        $this->addSql('ALTER TABLE pokemon_ability DROP FOREIGN KEY FK_59A592AD8016D8B2');
        $this->addSql('ALTER TABLE pokemon_stat DROP FOREIGN KEY FK_1C1181622FE71C3E');
        $this->addSql('ALTER TABLE pokemon_stat DROP FOREIGN KEY FK_1C1181629502F0B');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_B077296A2FE71C3E');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_B077296AC54C8C93');
        $this->addSql('DROP TABLE ability');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_ability');
        $this->addSql('DROP TABLE pokemon_stat');
        $this->addSql('DROP TABLE pokemon_type');
        $this->addSql('DROP TABLE stat');
        $this->addSql('DROP TABLE type');
    }
}
