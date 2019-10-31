<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030234032 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ashop_user_services CHANGE server server INT DEFAULT NULL, CHANGE service service INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ashop_user_services ADD CONSTRAINT FK_8CDE8E205A6DD5F6 FOREIGN KEY (server) REFERENCES ashop_servers (id)');
        $this->addSql('ALTER TABLE ashop_user_services ADD CONSTRAINT FK_8CDE8E20E19D9AD2 FOREIGN KEY (service) REFERENCES ashop_services (id)');
        $this->addSql('CREATE INDEX IDX_8CDE8E205A6DD5F6 ON ashop_user_services (server)');
        $this->addSql('CREATE INDEX IDX_8CDE8E20E19D9AD2 ON ashop_user_services (service)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ashop_user_services DROP FOREIGN KEY FK_8CDE8E205A6DD5F6');
        $this->addSql('ALTER TABLE ashop_user_services DROP FOREIGN KEY FK_8CDE8E20E19D9AD2');
        $this->addSql('DROP INDEX IDX_8CDE8E205A6DD5F6 ON ashop_user_services');
        $this->addSql('DROP INDEX IDX_8CDE8E20E19D9AD2 ON ashop_user_services');
        $this->addSql('ALTER TABLE ashop_user_services CHANGE server server INT NOT NULL, CHANGE service service INT NOT NULL');
    }
}
