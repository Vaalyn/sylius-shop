<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724180205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_refund_credit_memo_line_items (credit_memo_id VARCHAR(255) NOT NULL, line_item_id INT NOT NULL, INDEX IDX_1453B90E8E574316 (credit_memo_id), UNIQUE INDEX UNIQ_1453B90EA7CBD339 (line_item_id), PRIMARY KEY(credit_memo_id, line_item_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_credit_memo_tax_items (credit_memo_id VARCHAR(255) NOT NULL, tax_item_id INT NOT NULL, INDEX IDX_9BBDFBE28E574316 (credit_memo_id), UNIQUE INDEX UNIQ_9BBDFBE25327F254 (tax_item_id), PRIMARY KEY(credit_memo_id, tax_item_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_line_item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, unit_net_price INT NOT NULL, unit_gross_price INT NOT NULL, net_value INT NOT NULL, gross_value INT NOT NULL, tax_amount INT NOT NULL, tax_rate VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_tax_item (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_refund_payment (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT DEFAULT NULL, order_number VARCHAR(255) NOT NULL, amount INT NOT NULL, currency_code VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_EC283EA55AA1164F (payment_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items ADD CONSTRAINT FK_1453B90E8E574316 FOREIGN KEY (credit_memo_id) REFERENCES sylius_refund_credit_memo (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items ADD CONSTRAINT FK_1453B90EA7CBD339 FOREIGN KEY (line_item_id) REFERENCES sylius_refund_line_item (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items ADD CONSTRAINT FK_9BBDFBE28E574316 FOREIGN KEY (credit_memo_id) REFERENCES sylius_refund_credit_memo (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items ADD CONSTRAINT FK_9BBDFBE25327F254 FOREIGN KEY (tax_item_id) REFERENCES sylius_refund_tax_item (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_payment ADD CONSTRAINT FK_EC283EA55AA1164F FOREIGN KEY (payment_method_id) REFERENCES sylius_payment_method (id)');
        $this->addSql('DROP TABLE sylius_refund_payment');
        $this->addSql('ALTER TABLE sylius_refund_customer_billing_data ADD last_name VARCHAR(255) NOT NULL, CHANGE customer_name first_name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_5C4F3331551F0F81 ON sylius_refund_credit_memo');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD order_id INT DEFAULT NULL, DROP order_number, DROP units, CHANGE issued_at issued_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD CONSTRAINT FK_5C4F33318D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C4F333196901F54 ON sylius_refund_credit_memo (number)');
        $this->addSql('CREATE INDEX IDX_5C4F33318D9F6D38 ON sylius_refund_credit_memo (order_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items DROP FOREIGN KEY FK_1453B90EA7CBD339');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items DROP FOREIGN KEY FK_9BBDFBE25327F254');
        $this->addSql('CREATE TABLE sylius_refund_payment (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT DEFAULT NULL, order_number VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, amount INT NOT NULL, currency_code VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, state VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, INDEX IDX_EFA5A4B25AA1164F (payment_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sylius_refund_payment ADD CONSTRAINT FK_EFA5A4B25AA1164F FOREIGN KEY (payment_method_id) REFERENCES sylius_payment_method (id)');
        $this->addSql('DROP TABLE sylius_refund_credit_memo_line_items');
        $this->addSql('DROP TABLE sylius_refund_credit_memo_tax_items');
        $this->addSql('DROP TABLE sylius_refund_line_item');
        $this->addSql('DROP TABLE sylius_refund_tax_item');
        $this->addSql('DROP TABLE sylius_refund_refund_payment');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo DROP FOREIGN KEY FK_5C4F33318D9F6D38');
        $this->addSql('DROP INDEX UNIQ_5C4F333196901F54 ON sylius_refund_credit_memo');
        $this->addSql('DROP INDEX IDX_5C4F33318D9F6D38 ON sylius_refund_credit_memo');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD order_number VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD units JSON NOT NULL, DROP order_id, CHANGE issued_at issued_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_5C4F3331551F0F81 ON sylius_refund_credit_memo (order_number)');
        $this->addSql('ALTER TABLE sylius_refund_customer_billing_data ADD customer_name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP first_name, DROP last_name');
    }
}
