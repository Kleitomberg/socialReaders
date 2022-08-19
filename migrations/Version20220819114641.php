<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819114641 extends AbstractMigration
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
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, conteudo VARCHAR(255) NOT NULL, criado_em DATETIME NOT NULL, atualizado_em DATETIME NOT NULL, INDEX IDX_5A8A6C8DDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postagem (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, conteudo VARCHAR(255) NOT NULL, criado_em DATETIME NOT NULL, atualizado_em DATETIME NOT NULL, INDEX IDX_D0E38451DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicitacao_amizade (id INT AUTO_INCREMENT NOT NULL, id_solicitante_id INT DEFAULT NULL, id_solicitado_id INT DEFAULT NULL, situacao TINYINT(1) NOT NULL, data_solicitacao DATETIME NOT NULL, data_confirmacao DATETIME NOT NULL, UNIQUE INDEX UNIQ_2E09F352310EB781 (id_solicitante_id), UNIQUE INDEX UNIQ_2E09F3527CAA5B5D (id_solicitado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nome VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, imageprofile VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, senha VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amigos_user ADD CONSTRAINT FK_12F6FBA516C8F13B FOREIGN KEY (amigos_id) REFERENCES amigos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amigos_user ADD CONSTRAINT FK_12F6FBA5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE postagem ADD CONSTRAINT FK_D0E38451DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE solicitacao_amizade ADD CONSTRAINT FK_2E09F352310EB781 FOREIGN KEY (id_solicitante_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE solicitacao_amizade ADD CONSTRAINT FK_2E09F3527CAA5B5D FOREIGN KEY (id_solicitado_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amigos_user DROP FOREIGN KEY FK_12F6FBA516C8F13B');
        $this->addSql('ALTER TABLE amigos_user DROP FOREIGN KEY FK_12F6FBA5A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DDB38439E');
        $this->addSql('ALTER TABLE solicitacao_amizade DROP FOREIGN KEY FK_2E09F352310EB781');
        $this->addSql('ALTER TABLE solicitacao_amizade DROP FOREIGN KEY FK_2E09F3527CAA5B5D');
        $this->addSql('ALTER TABLE postagem DROP FOREIGN KEY FK_D0E38451DB38439E');
        $this->addSql('DROP TABLE amigos');
        $this->addSql('DROP TABLE amigos_user');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE postagem');
        $this->addSql('DROP TABLE solicitacao_amizade');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
