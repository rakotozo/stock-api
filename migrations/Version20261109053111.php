<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261109053111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_supplier ADD moto_model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_supplier ADD CONSTRAINT FK_509A06E9C3C6977E FOREIGN KEY (moto_model_id) REFERENCES moto_model (id)');
        $this->addSql('CREATE INDEX IDX_509A06E9C3C6977E ON product_supplier (moto_model_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_supplier DROP CONSTRAINT FK_509A06E9C3C6977E');
        $this->addSql('DROP INDEX IDX_509A06E9C3C6977E');
        $this->addSql('ALTER TABLE product_supplier DROP moto_model_id');
    }
}
