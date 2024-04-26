<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426112943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_line ADD orders_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_line ADD CONSTRAINT FK_5CFC9657CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5CFC9657CFFE9AD6 ON product_line (orders_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_line DROP FOREIGN KEY FK_5CFC9657CFFE9AD6');
        $this->addSql('DROP INDEX IDX_5CFC9657CFFE9AD6 ON product_line');
        $this->addSql('ALTER TABLE product_line DROP orders_id');
    }
}
