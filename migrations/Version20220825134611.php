<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825134611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversa ADD ultima_Mensagem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversa ADD CONSTRAINT FK_67FEFF8C90007590 FOREIGN KEY (ultima_Mensagem_id) REFERENCES mensagem (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67FEFF8C90007590 ON conversa (ultima_Mensagem_id)');
        $this->addSql('ALTER TABLE mensagem ADD usuario_id INT DEFAULT NULL, ADD conversa_id INT DEFAULT NULL, ADD conteudo VARCHAR(255) NOT NULL, ADD criado_em DATETIME NOT NULL');
        $this->addSql('ALTER TABLE mensagem ADD CONSTRAINT FK_9E4532B0DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mensagem ADD CONSTRAINT FK_9E4532B0474F05DA FOREIGN KEY (conversa_id) REFERENCES conversa (id)');
        $this->addSql('CREATE INDEX IDX_9E4532B0DB38439E ON mensagem (usuario_id)');
        $this->addSql('CREATE INDEX IDX_9E4532B0474F05DA ON mensagem (conversa_id)');
        $this->addSql('ALTER TABLE participante ADD usuario_id INT DEFAULT NULL, ADD conversa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participante ADD CONSTRAINT FK_85BDC5C3DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participante ADD CONSTRAINT FK_85BDC5C3474F05DA FOREIGN KEY (conversa_id) REFERENCES conversa (id)');
        $this->addSql('CREATE INDEX IDX_85BDC5C3DB38439E ON participante (usuario_id)');
        $this->addSql('CREATE INDEX IDX_85BDC5C3474F05DA ON participante (conversa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversa DROP FOREIGN KEY FK_67FEFF8C90007590');
        $this->addSql('DROP INDEX UNIQ_67FEFF8C90007590 ON conversa');
        $this->addSql('ALTER TABLE conversa DROP ultima_Mensagem_id');
        $this->addSql('ALTER TABLE mensagem DROP FOREIGN KEY FK_9E4532B0DB38439E');
        $this->addSql('ALTER TABLE mensagem DROP FOREIGN KEY FK_9E4532B0474F05DA');
        $this->addSql('DROP INDEX IDX_9E4532B0DB38439E ON mensagem');
        $this->addSql('DROP INDEX IDX_9E4532B0474F05DA ON mensagem');
        $this->addSql('ALTER TABLE mensagem DROP usuario_id, DROP conversa_id, DROP conteudo, DROP criado_em');
        $this->addSql('ALTER TABLE participante DROP FOREIGN KEY FK_85BDC5C3DB38439E');
        $this->addSql('ALTER TABLE participante DROP FOREIGN KEY FK_85BDC5C3474F05DA');
        $this->addSql('DROP INDEX IDX_85BDC5C3DB38439E ON participante');
        $this->addSql('DROP INDEX IDX_85BDC5C3474F05DA ON participante');
        $this->addSql('ALTER TABLE participante DROP usuario_id, DROP conversa_id');
    }
}
