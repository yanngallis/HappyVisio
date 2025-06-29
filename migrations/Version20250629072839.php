<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250629072839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', blocked_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_change_password_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', inactive_reminder_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', gender VARCHAR(1) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, address2 VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, birth_year INT NOT NULL, comment LONGTEXT DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, number_of_try INT DEFAULT NULL, is_blocked TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, is_banned TINYINT(1) NOT NULL, is_force_change_password TINYINT(1) NOT NULL, is_force_complex_password TINYINT(1) NOT NULL, is_mail_upcoming_rdv TINYINT(1) NOT NULL, is_mail_registration_confirmation TINYINT(1) NOT NULL, is_mail_reminder24_hours TINYINT(1) NOT NULL, is_mail_reminder1_hour TINYINT(1) NOT NULL, is_mail_post_activity TINYINT(1) NOT NULL, is_mail_newsletter TINYINT(1) NOT NULL, is_smsreminder1_hour TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649989D9B62 (slug), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
    }
}
