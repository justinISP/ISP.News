<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE neos_demo_domain_model_registration');
        $this->addSql('ALTER TABLE neos_contentrepository_domain_model_nodedata DROP INDEX IDX_CE6515692D45FE4D, ADD UNIQUE INDEX UNIQ_CE6515692D45FE4D (movedto)');
        $this->addSql('DROP INDEX path ON neos_contentrepository_domain_model_nodedata');
        $this->addSql('CREATE INDEX pathindex ON neos_contentrepository_domain_model_nodedata (path(255))');
        $this->addSql('ALTER TABLE neos_media_domain_model_tag DROP FOREIGN KEY FK_CA4889693D8E604F');
        $this->addSql('ALTER TABLE neos_media_domain_model_tag ADD CONSTRAINT FK_CA4889693D8E604F FOREIGN KEY (parent) REFERENCES neos_media_domain_model_tag (persistence_object_identifier) ON DELETE SET NULL');
        $this->addSql('DROP INDEX sourceuripathhash ON neos_redirecthandler_databasestorage_domain_model_redirect');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE neos_demo_domain_model_registration (persistence_object_identifier VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE neos_contentrepository_domain_model_nodedata DROP INDEX UNIQ_CE6515692D45FE4D, ADD INDEX IDX_CE6515692D45FE4D (movedto)');
        $this->addSql('DROP INDEX pathindex ON neos_contentrepository_domain_model_nodedata');
        $this->addSql('CREATE INDEX path ON neos_contentrepository_domain_model_nodedata (path(255))');
        $this->addSql('ALTER TABLE neos_media_domain_model_tag DROP FOREIGN KEY FK_CA4889693D8E604F');
        $this->addSql('ALTER TABLE neos_media_domain_model_tag ADD CONSTRAINT FK_CA4889693D8E604F FOREIGN KEY (parent) REFERENCES neos_media_domain_model_tag (persistence_object_identifier)');
        $this->addSql('CREATE INDEX sourceuripathhash ON neos_redirecthandler_databasestorage_domain_model_redirect (sourceuripathhash, host)');
    }
}
