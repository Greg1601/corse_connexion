<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180730144617 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email (address VARCHAR(255) NOT NULL, user_type_id INT NOT NULL, INDEX IDX_E7927C749D419299 (user_type_id), PRIMARY KEY(address)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C749D419299 FOREIGN KEY (user_type_id) REFERENCES usertype (id)');
        $this->addSql('DROP TABLE company_email');
        $this->addSql('DROP TABLE talent_email');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company_email (address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, user_type_id INT NOT NULL, INDEX IDX_A063DE119D419299 (user_type_id), PRIMARY KEY(address)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talent_email (address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, user_type_id INT NOT NULL, INDEX IDX_11C262F39D419299 (user_type_id), PRIMARY KEY(address)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_email ADD CONSTRAINT FK_A063DE119D419299 FOREIGN KEY (user_type_id) REFERENCES usertype (id)');
        $this->addSql('ALTER TABLE talent_email ADD CONSTRAINT FK_11C262F39D419299 FOREIGN KEY (user_type_id) REFERENCES usertype (id)');
        $this->addSql('DROP TABLE email');
    }
}
