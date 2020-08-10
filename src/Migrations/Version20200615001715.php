<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200615001715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bitbag_product_bundle_order_item (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, order_item_id INT NOT NULL, product_bundle_item_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A615CDA9A80EF684 (product_variant_id), INDEX IDX_A615CDA9E415FB15 (order_item_id), INDEX IDX_A615CDA9B7FE950B (product_bundle_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_product_bundle (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, is_packed_product TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9EBE7ABF4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_product_bundle_item (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, product_bundle_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_F429FEB6A80EF684 (product_variant_id), INDEX IDX_F429FEB69F5A6F5E (product_bundle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_product_bundle_order_item ADD CONSTRAINT FK_A615CDA9A80EF684 FOREIGN KEY (product_variant_id) REFERENCES sylius_product_variant (id)');
        $this->addSql('ALTER TABLE bitbag_product_bundle_order_item ADD CONSTRAINT FK_A615CDA9E415FB15 FOREIGN KEY (order_item_id) REFERENCES sylius_order_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_product_bundle_order_item ADD CONSTRAINT FK_A615CDA9B7FE950B FOREIGN KEY (product_bundle_item_id) REFERENCES bitbag_product_bundle_item (id)');
        $this->addSql('ALTER TABLE bitbag_product_bundle ADD CONSTRAINT FK_9EBE7ABF4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE bitbag_product_bundle_item ADD CONSTRAINT FK_F429FEB6A80EF684 FOREIGN KEY (product_variant_id) REFERENCES sylius_product_variant (id)');
        $this->addSql('ALTER TABLE bitbag_product_bundle_item ADD CONSTRAINT FK_F429FEB69F5A6F5E FOREIGN KEY (product_bundle_id) REFERENCES bitbag_product_bundle (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bitbag_product_bundle_item DROP FOREIGN KEY FK_F429FEB69F5A6F5E');
        $this->addSql('ALTER TABLE bitbag_product_bundle_order_item DROP FOREIGN KEY FK_A615CDA9B7FE950B');
        $this->addSql('DROP TABLE bitbag_product_bundle_order_item');
        $this->addSql('DROP TABLE bitbag_product_bundle');
        $this->addSql('DROP TABLE bitbag_product_bundle_item');
    }
}
