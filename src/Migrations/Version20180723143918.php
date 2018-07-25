<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180723143918 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE email DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE email ADD address VARCHAR(255) NOT NULL, DROP id, DROP email_address');
        $this->addSql('ALTER TABLE email ADD PRIMARY KEY (address)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE email ADD id INT AUTO_INCREMENT NOT NULL, ADD email_address LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, DROP address');
        $this->addSql('ALTER TABLE email ADD PRIMARY KEY (id)');
    }
}
