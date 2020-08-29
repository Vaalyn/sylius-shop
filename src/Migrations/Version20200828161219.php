<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828161219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mangoweb_contact_form_message_answer (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, createdAt DATETIME NOT NULL, contactFormMessage_id INT DEFAULT NULL, adminUser_id INT DEFAULT NULL, INDEX IDX_20F9FD763177599 (contactFormMessage_id), INDEX IDX_20F9FD7CC283C73 (adminUser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mangoweb_contact_form (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, customerName VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) DEFAULT NULL, message LONGTEXT NOT NULL, createdAt DATETIME NOT NULL, userAgent VARCHAR(255) DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, INDEX IDX_9D2162F49395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mangoweb_contact_form_message_answer ADD CONSTRAINT FK_20F9FD763177599 FOREIGN KEY (contactFormMessage_id) REFERENCES mangoweb_contact_form (id)');
        $this->addSql('ALTER TABLE mangoweb_contact_form_message_answer ADD CONSTRAINT FK_20F9FD7CC283C73 FOREIGN KEY (adminUser_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE mangoweb_contact_form ADD CONSTRAINT FK_9D2162F49395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mangoweb_contact_form_message_answer DROP FOREIGN KEY FK_20F9FD763177599');
        $this->addSql('DROP TABLE mangoweb_contact_form_message_answer');
        $this->addSql('DROP TABLE mangoweb_contact_form');
    }
}
