<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150923151925 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE language_level (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(4) NOT NULL, level_name VARCHAR(100) NOT NULL, level_group VARCHAR(4) NOT NULL, level_group_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, language_level_id INT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, birthday DATE NOT NULL, INDEX IDX_B723AF333313139D (language_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_student (student_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_7AE12272CB944F1A (student_id), INDEX IDX_7AE1227241807E1D (teacher_id), PRIMARY KEY(student_id, teacher_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, sex TINYINT(1) NOT NULL, phone VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF333313139D FOREIGN KEY (language_level_id) REFERENCES language_level (id)');
        $this->addSql('ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE12272CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE1227241807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');

        $this->addSql("insert into language_level (level, level_name, level_group, level_group_name)
        values ('A1', 'Breakthrough or beginner', 'A', 'Basic user')");
        $this->addSql("insert into language_level (level, level_name, level_group, level_group_name)
        values ('A2', 'Way stage or elementary', 'A', 'Basic user')");

        $this->addSql("insert into language_level (level, level_name, level_group, level_group_name)
        values ('B2', 'Threshold or intermediate', 'B', 'Independent user')");
        $this->addSql("insert into language_level (level, level_name, level_group, level_group_name)
        values ('B2', 'Vantage or upper intermediate', 'B', 'Independent user')");

        $this->addSql("insert into language_level (level, level_name, level_group, level_group_name)
        values ('C1', 'Effective operational proficiency or advanced', 'C', 'Proficient user')");
        $this->addSql("insert into language_level (level, level_name, level_group, level_group_name)
        values ('C2', 'Mastery or proficiency', 'C', 'Proficient user')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF333313139D');
        $this->addSql('ALTER TABLE teacher_student DROP FOREIGN KEY FK_7AE12272CB944F1A');
        $this->addSql('ALTER TABLE teacher_student DROP FOREIGN KEY FK_7AE1227241807E1D');
        $this->addSql('DROP TABLE language_level');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher_student');
        $this->addSql('DROP TABLE teacher');
    }
}
