<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031061518 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ashop_admin_login_logs (id INT AUTO_INCREMENT NOT NULL, admin_ip VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, success TINYINT(1) DEFAULT \'0\' NOT NULL, adminName VARCHAR(255) DEFAULT NULL, INDEX IDX_634A4D82C57D9BB7 (adminName), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_admin_logs (id INT AUTO_INCREMENT NOT NULL, admin_ip VARCHAR(255) DEFAULT NULL, content VARCHAR(256) NOT NULL, date DATETIME NOT NULL, adminName VARCHAR(255) DEFAULT NULL, INDEX IDX_6A4FD3EC57D9BB7 (adminName), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_bought_services_logs (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT NULL, server INT DEFAULT NULL, service INT DEFAULT NULL, payment_type INT NOT NULL, value INT NOT NULL, auth_data VARCHAR(255) DEFAULT NULL, user_ip VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_790A0882F85E0677 (username), INDEX IDX_790A08825A6DD5F6 (server), INDEX IDX_790A0882E19D9AD2 (service), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_groups_permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(48) NOT NULL, value VARCHAR(128) NOT NULL, groupId INT DEFAULT NULL, INDEX IDX_5D26622DED8188B0 (groupId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(48) NOT NULL, style VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_noffications (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, title VARCHAR(48) NOT NULL, content VARCHAR(256) NOT NULL, viited TINYINT(1) DEFAULT \'0\' NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_payment_methods (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, name VARCHAR(64) NOT NULL, smskey VARCHAR(24) DEFAULT NULL, apikey VARCHAR(64) DEFAULT NULL, apisecret VARCHAR(64) DEFAULT NULL, service_id INT DEFAULT NULL, method_name VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_147A48065E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_payments_psc (id INT AUTO_INCREMENT NOT NULL, cost DOUBLE PRECISION NOT NULL, ip VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, paymentMethod INT NOT NULL, INDEX IDX_A8C8C0CD8484E578 (paymentMethod), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_payments_sms (id INT AUTO_INCREMENT NOT NULL, income DOUBLE PRECISION NOT NULL, cost DOUBLE PRECISION NOT NULL, code VARCHAR(16) NOT NULL, number INT NOT NULL, ip VARCHAR(255) DEFAULT NULL, platform VARCHAR(16) NOT NULL, date DATETIME NOT NULL, paymentMethod INT DEFAULT NULL, INDEX IDX_6378512F8484E578 (paymentMethod), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_payments_transfer (id INT AUTO_INCREMENT NOT NULL, cost DOUBLE PRECISION NOT NULL, ip VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, paymentMethod INT DEFAULT NULL, INDEX IDX_822E9E138484E578 (paymentMethod), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_payments_wallet (id INT AUTO_INCREMENT NOT NULL, cost DOUBLE PRECISION NOT NULL, ip VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_prices (id INT AUTO_INCREMENT NOT NULL, service INT DEFAULT NULL, tariff INT DEFAULT NULL, server VARCHAR(255) DEFAULT NULL, value INT NOT NULL, INDEX IDX_C2CC1C3FE19D9AD2 (service), INDEX IDX_C2CC1C3F9465207D (tariff), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_servers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, ip_address VARCHAR(255) DEFAULT NULL, port INT NOT NULL, type INT NOT NULL, rcon_password VARCHAR(64) NOT NULL, connected TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_services (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, web_description VARCHAR(255) DEFAULT NULL, server_description VARCHAR(255) DEFAULT NULL, image_url VARCHAR(256) DEFAULT NULL, sufix VARCHAR(16) NOT NULL, type INT NOT NULL, flags VARCHAR(32) NOT NULL, order_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_settings (name VARCHAR(32) NOT NULL, value VARCHAR(128) NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_tariffs (id INT AUTO_INCREMENT NOT NULL, sms_number INT DEFAULT NULL, brutto DOUBLE PRECISION NOT NULL, netto DOUBLE PRECISION NOT NULL, paymentMethod INT DEFAULT NULL, INDEX IDX_91D964B68484E578 (paymentMethod), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_temporary_payments (payment_hash VARCHAR(255) NOT NULL, server INT DEFAULT NULL, service INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, auth_data VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT \'0\' NOT NULL, date DATETIME NOT NULL, INDEX IDX_4D2CDB935A6DD5F6 (server), INDEX IDX_4D2CDB93E19D9AD2 (service), PRIMARY KEY(payment_hash)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_url_shortener (id INT AUTO_INCREMENT NOT NULL, oryginal_url VARCHAR(256) NOT NULL, new_url VARCHAR(128) NOT NULL, expires DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_users (username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', auth_data VARCHAR(64) NOT NULL, wallet DOUBLE PRECISION NOT NULL, join_date DATETIME NOT NULL, groupId INT DEFAULT NULL, UNIQUE INDEX UNIQ_CAC26FD9E7927C74 (email), INDEX IDX_CAC26FD9ED8188B0 (groupId), PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_user_services (id INT AUTO_INCREMENT NOT NULL, server INT DEFAULT NULL, service INT DEFAULT NULL, value INT NOT NULL, auth_data VARCHAR(255) DEFAULT NULL, bought_date DATETIME NOT NULL, expires DATETIME NOT NULL, INDEX IDX_8CDE8E205A6DD5F6 (server), INDEX IDX_8CDE8E20E19D9AD2 (service), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ashop_vouchers (id INT AUTO_INCREMENT NOT NULL, price INT DEFAULT NULL, code VARCHAR(6) NOT NULL, INDEX IDX_87B0ACC4CAC822D9 (price), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ashop_admin_login_logs ADD CONSTRAINT FK_634A4D82C57D9BB7 FOREIGN KEY (adminName) REFERENCES ashop_users (username)');
        $this->addSql('ALTER TABLE ashop_admin_logs ADD CONSTRAINT FK_6A4FD3EC57D9BB7 FOREIGN KEY (adminName) REFERENCES ashop_users (username)');
        $this->addSql('ALTER TABLE ashop_bought_services_logs ADD CONSTRAINT FK_790A0882F85E0677 FOREIGN KEY (username) REFERENCES ashop_users (username)');
        $this->addSql('ALTER TABLE ashop_bought_services_logs ADD CONSTRAINT FK_790A08825A6DD5F6 FOREIGN KEY (server) REFERENCES ashop_servers (id)');
        $this->addSql('ALTER TABLE ashop_bought_services_logs ADD CONSTRAINT FK_790A0882E19D9AD2 FOREIGN KEY (service) REFERENCES ashop_services (id)');
        $this->addSql('ALTER TABLE ashop_groups_permissions ADD CONSTRAINT FK_5D26622DED8188B0 FOREIGN KEY (groupId) REFERENCES ashop_groups (id)');
        $this->addSql('ALTER TABLE ashop_payments_psc ADD CONSTRAINT FK_A8C8C0CD8484E578 FOREIGN KEY (paymentMethod) REFERENCES ashop_payment_methods (id)');
        $this->addSql('ALTER TABLE ashop_payments_sms ADD CONSTRAINT FK_6378512F8484E578 FOREIGN KEY (paymentMethod) REFERENCES ashop_payment_methods (id)');
        $this->addSql('ALTER TABLE ashop_payments_transfer ADD CONSTRAINT FK_822E9E138484E578 FOREIGN KEY (paymentMethod) REFERENCES ashop_payment_methods (id)');
        $this->addSql('ALTER TABLE ashop_prices ADD CONSTRAINT FK_C2CC1C3FE19D9AD2 FOREIGN KEY (service) REFERENCES ashop_services (id)');
        $this->addSql('ALTER TABLE ashop_prices ADD CONSTRAINT FK_C2CC1C3F9465207D FOREIGN KEY (tariff) REFERENCES ashop_tariffs (id)');
        $this->addSql('ALTER TABLE ashop_tariffs ADD CONSTRAINT FK_91D964B68484E578 FOREIGN KEY (paymentMethod) REFERENCES ashop_payment_methods (id)');
        $this->addSql('ALTER TABLE ashop_temporary_payments ADD CONSTRAINT FK_4D2CDB935A6DD5F6 FOREIGN KEY (server) REFERENCES ashop_servers (id)');
        $this->addSql('ALTER TABLE ashop_temporary_payments ADD CONSTRAINT FK_4D2CDB93E19D9AD2 FOREIGN KEY (service) REFERENCES ashop_services (id)');
        $this->addSql('ALTER TABLE ashop_users ADD CONSTRAINT FK_CAC26FD9ED8188B0 FOREIGN KEY (groupId) REFERENCES ashop_groups (id)');
        $this->addSql('ALTER TABLE ashop_user_services ADD CONSTRAINT FK_8CDE8E205A6DD5F6 FOREIGN KEY (server) REFERENCES ashop_servers (id)');
        $this->addSql('ALTER TABLE ashop_user_services ADD CONSTRAINT FK_8CDE8E20E19D9AD2 FOREIGN KEY (service) REFERENCES ashop_services (id)');
        $this->addSql('ALTER TABLE ashop_vouchers ADD CONSTRAINT FK_87B0ACC4CAC822D9 FOREIGN KEY (price) REFERENCES ashop_prices (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ashop_groups_permissions DROP FOREIGN KEY FK_5D26622DED8188B0');
        $this->addSql('ALTER TABLE ashop_users DROP FOREIGN KEY FK_CAC26FD9ED8188B0');
        $this->addSql('ALTER TABLE ashop_payments_psc DROP FOREIGN KEY FK_A8C8C0CD8484E578');
        $this->addSql('ALTER TABLE ashop_payments_sms DROP FOREIGN KEY FK_6378512F8484E578');
        $this->addSql('ALTER TABLE ashop_payments_transfer DROP FOREIGN KEY FK_822E9E138484E578');
        $this->addSql('ALTER TABLE ashop_tariffs DROP FOREIGN KEY FK_91D964B68484E578');
        $this->addSql('ALTER TABLE ashop_vouchers DROP FOREIGN KEY FK_87B0ACC4CAC822D9');
        $this->addSql('ALTER TABLE ashop_bought_services_logs DROP FOREIGN KEY FK_790A08825A6DD5F6');
        $this->addSql('ALTER TABLE ashop_temporary_payments DROP FOREIGN KEY FK_4D2CDB935A6DD5F6');
        $this->addSql('ALTER TABLE ashop_user_services DROP FOREIGN KEY FK_8CDE8E205A6DD5F6');
        $this->addSql('ALTER TABLE ashop_bought_services_logs DROP FOREIGN KEY FK_790A0882E19D9AD2');
        $this->addSql('ALTER TABLE ashop_prices DROP FOREIGN KEY FK_C2CC1C3FE19D9AD2');
        $this->addSql('ALTER TABLE ashop_temporary_payments DROP FOREIGN KEY FK_4D2CDB93E19D9AD2');
        $this->addSql('ALTER TABLE ashop_user_services DROP FOREIGN KEY FK_8CDE8E20E19D9AD2');
        $this->addSql('ALTER TABLE ashop_prices DROP FOREIGN KEY FK_C2CC1C3F9465207D');
        $this->addSql('ALTER TABLE ashop_admin_login_logs DROP FOREIGN KEY FK_634A4D82C57D9BB7');
        $this->addSql('ALTER TABLE ashop_admin_logs DROP FOREIGN KEY FK_6A4FD3EC57D9BB7');
        $this->addSql('ALTER TABLE ashop_bought_services_logs DROP FOREIGN KEY FK_790A0882F85E0677');
        $this->addSql('DROP TABLE ashop_admin_login_logs');
        $this->addSql('DROP TABLE ashop_admin_logs');
        $this->addSql('DROP TABLE ashop_bought_services_logs');
        $this->addSql('DROP TABLE ashop_groups_permissions');
        $this->addSql('DROP TABLE ashop_groups');
        $this->addSql('DROP TABLE ashop_noffications');
        $this->addSql('DROP TABLE ashop_payment_methods');
        $this->addSql('DROP TABLE ashop_payments_psc');
        $this->addSql('DROP TABLE ashop_payments_sms');
        $this->addSql('DROP TABLE ashop_payments_transfer');
        $this->addSql('DROP TABLE ashop_payments_wallet');
        $this->addSql('DROP TABLE ashop_prices');
        $this->addSql('DROP TABLE ashop_servers');
        $this->addSql('DROP TABLE ashop_services');
        $this->addSql('DROP TABLE ashop_settings');
        $this->addSql('DROP TABLE ashop_tariffs');
        $this->addSql('DROP TABLE ashop_temporary_payments');
        $this->addSql('DROP TABLE ashop_url_shortener');
        $this->addSql('DROP TABLE ashop_users');
        $this->addSql('DROP TABLE ashop_user_services');
        $this->addSql('DROP TABLE ashop_vouchers');
    }
}
