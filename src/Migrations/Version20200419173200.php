<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200419173200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE setono_sylius_terms__terms_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, explanation VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_F347D1FE2C2AC5D3 (translatable_id), UNIQUE INDEX uniq_slug (locale, slug), UNIQUE INDEX setono_sylius_terms__terms_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setono_sylius_terms__terms (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_213B63E977153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setono_sylius_terms__terms_channels (terms_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_73B1100553742F27 (terms_id), INDEX IDX_73B1100572F5A1AA (channel_id), PRIMARY KEY(terms_id, channel_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setono_sylius_terms__terms_translation ADD CONSTRAINT FK_F347D1FE2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES setono_sylius_terms__terms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE setono_sylius_terms__terms_channels ADD CONSTRAINT FK_73B1100553742F27 FOREIGN KEY (terms_id) REFERENCES setono_sylius_terms__terms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE setono_sylius_terms__terms_channels ADD CONSTRAINT FK_73B1100572F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE setono_sylius_terms__terms_translation DROP FOREIGN KEY FK_F347D1FE2C2AC5D3');
        $this->addSql('ALTER TABLE setono_sylius_terms__terms_channels DROP FOREIGN KEY FK_73B1100553742F27');
        $this->addSql('DROP TABLE setono_sylius_terms__terms_translation');
        $this->addSql('DROP TABLE setono_sylius_terms__terms');
        $this->addSql('DROP TABLE setono_sylius_terms__terms_channels');
    }
}
