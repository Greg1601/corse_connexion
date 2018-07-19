<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180719153239 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, body LONGTEXT NOT NULL, picture LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, description LONGTEXT NOT NULL, picture LONGTEXT DEFAULT NULL, begins DATETIME NOT NULL, ends DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, user_type_id INT NOT NULL, email_address LONGTEXT NOT NULL, INDEX IDX_E7927C749D419299 (user_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talent (id INT AUTO_INCREMENT NOT NULL, firstname LONGTEXT NOT NULL, lastname LONGTEXT NOT NULL, email LONGTEXT NOT NULL, phone LONGTEXT NOT NULL, picture LONGTEXT DEFAULT NULL, linkedin_profile LONGTEXT DEFAULT NULL, password LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talent_skill (talent_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_A86DFAF018777CEF (talent_id), INDEX IDX_A86DFAF05585C142 (skill_id), PRIMARY KEY(talent_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opportunity (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title LONGTEXT NOT NULL, body LONGTEXT NOT NULL, contact LONGTEXT NOT NULL, salary LONGTEXT DEFAULT NULL, required_expertise LONGTEXT NOT NULL, place LONGTEXT NOT NULL, remote_possibility TINYINT(1) NOT NULL, INDEX IDX_8389C3D7979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opportunity_skill (opportunity_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_6A9EA1F9A34590F (opportunity_id), INDEX IDX_6A9EA1F5585C142 (skill_id), PRIMARY KEY(opportunity_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 0) NOT NULL, picture LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usertype (id INT AUTO_INCREMENT NOT NULL, type LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, company_name LONGTEXT NOT NULL, email LONGTEXT NOT NULL, contact_name LONGTEXT NOT NULL, contact_phone LONGTEXT NOT NULL, picture LONGTEXT DEFAULT NULL, project LONGTEXT DEFAULT NULL, password LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C749D419299 FOREIGN KEY (user_type_id) REFERENCES usertype (id)');
        $this->addSql('ALTER TABLE talent_skill ADD CONSTRAINT FK_A86DFAF018777CEF FOREIGN KEY (talent_id) REFERENCES talent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE talent_skill ADD CONSTRAINT FK_A86DFAF05585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE opportunity_skill ADD CONSTRAINT FK_6A9EA1F9A34590F FOREIGN KEY (opportunity_id) REFERENCES opportunity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE opportunity_skill ADD CONSTRAINT FK_6A9EA1F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE talent_skill DROP FOREIGN KEY FK_A86DFAF05585C142');
        $this->addSql('ALTER TABLE opportunity_skill DROP FOREIGN KEY FK_6A9EA1F5585C142');
        $this->addSql('ALTER TABLE talent_skill DROP FOREIGN KEY FK_A86DFAF018777CEF');
        $this->addSql('ALTER TABLE opportunity_skill DROP FOREIGN KEY FK_6A9EA1F9A34590F');
        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C749D419299');
        $this->addSql('ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7979B1AD6');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE talent');
        $this->addSql('DROP TABLE talent_skill');
        $this->addSql('DROP TABLE opportunity');
        $this->addSql('DROP TABLE opportunity_skill');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE usertype');
        $this->addSql('DROP TABLE company');
    }
}
