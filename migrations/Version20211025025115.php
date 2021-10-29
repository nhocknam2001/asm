<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025025115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, descripion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, grade INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_student (course_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_BFE0AADF591CC992 (course_id), INDEX IDX_BFE0AADFCB944F1A (student_id), PRIMARY KEY(course_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, birthday DATE NOT NULL, avatar VARCHAR(255) NOT NULL, course VARCHAR(255) NOT NULL, INDEX IDX_B723AF3312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, birthday DATE NOT NULL, avatar VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_course (teacher_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_315BD4C41807E1D (teacher_id), INDEX IDX_315BD4C591CC992 (course_id), PRIMARY KEY(teacher_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADFCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE teacher_course ADD CONSTRAINT FK_315BD4C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_course ADD CONSTRAINT FK_315BD4C591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF3312469DE2');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADF591CC992');
        $this->addSql('ALTER TABLE teacher_course DROP FOREIGN KEY FK_315BD4C591CC992');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADFCB944F1A');
        $this->addSql('ALTER TABLE teacher_course DROP FOREIGN KEY FK_315BD4C41807E1D');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_student');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE teacher_course');
    }
}
