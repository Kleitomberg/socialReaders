<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812122611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amigos (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amigos_user (amigos_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_12F6FBA516C8F13B (amigos_id), INDEX IDX_12F6FBA5A76ED395 (user_id), PRIMARY KEY(amigos_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicitacao_amizade (id INT AUTO_INCREMENT NOT NULL, id_solicitante_id INT DEFAULT NULL, id_solicitado_id INT DEFAULT NULL, situacao TINYINT(1) NOT NULL, data_solicitacao DATETIME NOT NULL, data_confirmacao DATETIME NOT NULL, UNIQUE INDEX UNIQ_2E09F352310EB781 (id_solicitante_id), UNIQUE INDEX UNIQ_2E09F3527CAA5B5D (id_solicitado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amigos_user ADD CONSTRAINT FK_12F6FBA516C8F13B FOREIGN KEY (amigos_id) REFERENCES amigos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amigos_user ADD CONSTRAINT FK_12F6FBA5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicitacao_amizade ADD CONSTRAINT FK_2E09F352310EB781 FOREIGN KEY (id_solicitante_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE solicitacao_amizade ADD CONSTRAINT FK_2E09F3527CAA5B5D FOREIGN KEY (id_solicitado_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amigos_user DROP FOREIGN KEY FK_12F6FBA516C8F13B');
        $this->addSql('DROP TABLE amigos');
        $this->addSql('DROP TABLE amigos_user');
        $this->addSql('DROP TABLE solicitacao_amizade');
    }
}
