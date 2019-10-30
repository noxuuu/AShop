<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030021333 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ashop_bought_services_logs DROP FOREIGN KEY FK_790A0882C57D9BB7');
        $this->addSql('DROP INDEX IDX_790A0882C57D9BB7 ON ashop_bought_services_logs');
        $this->addSql('ALTER TABLE ashop_bought_services_logs CHANGE adminname username VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ashop_bought_services_logs ADD CONSTRAINT FK_790A0882F85E0677 FOREIGN KEY (username) REFERENCES ashop_users (username)');
        $this->addSql('CREATE INDEX IDX_790A0882F85E0677 ON ashop_bought_services_logs (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ashop_bought_services_logs DROP FOREIGN KEY FK_790A0882F85E0677');
        $this->addSql('DROP INDEX IDX_790A0882F85E0677 ON ashop_bought_services_logs');
        $this->addSql('ALTER TABLE ashop_bought_services_logs CHANGE username adminName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE ashop_bought_services_logs ADD CONSTRAINT FK_790A0882C57D9BB7 FOREIGN KEY (adminName) REFERENCES ashop_users (username) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_790A0882C57D9BB7 ON ashop_bought_services_logs (adminName)');
    }
}
