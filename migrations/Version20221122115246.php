<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221122115246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accomodation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, price INT DEFAULT NULL, area INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, placeType VARCHAR(255) NOT NULL, INDEX IDX_520D81B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apartment (id INT NOT NULL, floor INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bed (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boat (id INT NOT NULL, roof_height INT DEFAULT NULL, motor INT DEFAULT NULL, is_moving TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, start_date_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', nb_customer INT DEFAULT NULL, price INT DEFAULT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house (id INT NOT NULL, garage INT DEFAULT NULL, pool INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, accomodation_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_729F519BFD70509C (accomodation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_bed (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, bed_id INT DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_E4C141E254177093 (room_id), INDEX IDX_E4C141E288688BB9 (bed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tree_house (id INT NOT NULL, tree_height INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, role LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E6854BF396750 FOREIGN KEY (id) REFERENCES accomodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boat ADD CONSTRAINT FK_D86E834ABF396750 FOREIGN KEY (id) REFERENCES accomodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE house ADD CONSTRAINT FK_67D5399DBF396750 FOREIGN KEY (id) REFERENCES accomodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BFD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('ALTER TABLE room_bed ADD CONSTRAINT FK_E4C141E254177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE room_bed ADD CONSTRAINT FK_E4C141E288688BB9 FOREIGN KEY (bed_id) REFERENCES bed (id)');
        $this->addSql('ALTER TABLE tree_house ADD CONSTRAINT FK_DFD71FF8BF396750 FOREIGN KEY (id) REFERENCES accomodation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B3A76ED395');
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E6854BF396750');
        $this->addSql('ALTER TABLE boat DROP FOREIGN KEY FK_D86E834ABF396750');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE house DROP FOREIGN KEY FK_67D5399DBF396750');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BFD70509C');
        $this->addSql('ALTER TABLE room_bed DROP FOREIGN KEY FK_E4C141E254177093');
        $this->addSql('ALTER TABLE room_bed DROP FOREIGN KEY FK_E4C141E288688BB9');
        $this->addSql('ALTER TABLE tree_house DROP FOREIGN KEY FK_DFD71FF8BF396750');
        $this->addSql('DROP TABLE accomodation');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE bed');
        $this->addSql('DROP TABLE boat');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE house');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_bed');
        $this->addSql('DROP TABLE tree_house');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
