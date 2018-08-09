<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180802160038 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7E7A1254A');
        $this->addSql('DROP INDEX UNIQ_8389C3D7E7A1254A ON opportunity');
        $this->addSql('ALTER TABLE opportunity ADD contact LONGTEXT NOT NULL, DROP contact_id');
        $this->addSql('ALTER TABLE company ADD contact_name LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP contact_name');
        $this->addSql('ALTER TABLE opportunity ADD contact_id INT DEFAULT NULL, DROP contact');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7E7A1254A FOREIGN KEY (contact_id) REFERENCES company (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8389C3D7E7A1254A ON opportunity (contact_id)');
    }
}
