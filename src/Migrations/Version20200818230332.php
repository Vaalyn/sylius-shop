<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818230332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE joppedc_seo_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, seo_page_title VARCHAR(255) DEFAULT \'\', seo_og_title VARCHAR(255) DEFAULT \'\', seo_og_description VARCHAR(255) DEFAULT \'\', seo_twitter_title VARCHAR(255) DEFAULT \'\', seo_twitter_description VARCHAR(255) DEFAULT \'\', seo_twitter_site VARCHAR(255) DEFAULT \'\', seo_extra_tags VARCHAR(255) DEFAULT \'\', locale VARCHAR(255) NOT NULL, INDEX IDX_9990ED9A2C2AC5D3 (translatable_id), UNIQUE INDEX joppedc_seo_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joppedc_seo (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joppedc_seo_image (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B803CDDB7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joppedc_seo_translation ADD CONSTRAINT FK_9990ED9A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES joppedc_seo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joppedc_seo_image ADD CONSTRAINT FK_B803CDDB7E3C61F9 FOREIGN KEY (owner_id) REFERENCES joppedc_seo_translation (id)');
        $this->addSql('ALTER TABLE sylius_product ADD seo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product ADD CONSTRAINT FK_677B9B7497E3DD86 FOREIGN KEY (seo_id) REFERENCES joppedc_seo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_677B9B7497E3DD86 ON sylius_product (seo_id)');
        $this->addSql('ALTER TABLE sylius_taxon ADD seo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CA97E3DD86 FOREIGN KEY (seo_id) REFERENCES joppedc_seo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFD811CA97E3DD86 ON sylius_taxon (seo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE joppedc_seo_image DROP FOREIGN KEY FK_B803CDDB7E3C61F9');
        $this->addSql('ALTER TABLE sylius_product DROP FOREIGN KEY FK_677B9B7497E3DD86');
        $this->addSql('ALTER TABLE sylius_taxon DROP FOREIGN KEY FK_CFD811CA97E3DD86');
        $this->addSql('ALTER TABLE joppedc_seo_translation DROP FOREIGN KEY FK_9990ED9A2C2AC5D3');
        $this->addSql('DROP TABLE joppedc_seo_translation');
        $this->addSql('DROP TABLE joppedc_seo');
        $this->addSql('DROP TABLE joppedc_seo_image');
        $this->addSql('DROP INDEX UNIQ_677B9B7497E3DD86 ON sylius_product');
        $this->addSql('ALTER TABLE sylius_product DROP seo_id');
        $this->addSql('DROP INDEX UNIQ_CFD811CA97E3DD86 ON sylius_taxon');
        $this->addSql('ALTER TABLE sylius_taxon DROP seo_id');
    }
}
