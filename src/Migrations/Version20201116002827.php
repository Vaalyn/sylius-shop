<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116002827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Missing migration from BitBag Mollie Plugin';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_mollie_product_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FCC472585E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration ADD defaultCategory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration ADD CONSTRAINT FK_23CC8504BFB2B62E FOREIGN KEY (defaultCategory_id) REFERENCES bitbag_mollie_product_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23CC8504BFB2B62E ON bitbag_mollie_configuration (defaultCategory_id)');
        $this->addSql('ALTER TABLE sylius_product ADD product_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product ADD CONSTRAINT FK_677B9B7414959723 FOREIGN KEY (product_type_id) REFERENCES bitbag_mollie_product_type (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_677B9B7414959723 ON sylius_product (product_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitbag_mollie_configuration DROP FOREIGN KEY FK_23CC8504BFB2B62E');
        $this->addSql('ALTER TABLE sylius_product DROP FOREIGN KEY FK_677B9B7414959723');
        $this->addSql('DROP TABLE bitbag_mollie_product_type');
        $this->addSql('DROP INDEX UNIQ_23CC8504BFB2B62E ON bitbag_mollie_configuration');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration DROP defaultCategory_id');
        $this->addSql('DROP INDEX IDX_677B9B7414959723 ON sylius_product');
        $this->addSql('ALTER TABLE sylius_product DROP product_type_id');
    }
}
