<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923071743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id UUID NOT NULL, answer_variant_id UUID DEFAULT NULL, test_question_id UUID DEFAULT NULL, selected BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A2554E42191 ON answer (answer_variant_id)');
        $this->addSql('CREATE INDEX IDX_DADD4A2541594D01 ON answer (test_question_id)');
        $this->addSql('COMMENT ON COLUMN answer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.answer_variant_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.test_question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE answer_variants (id UUID NOT NULL, question_id UUID DEFAULT NULL, text TEXT NOT NULL, correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94D252841E27F6BF ON answer_variants (question_id)');
        $this->addSql('COMMENT ON COLUMN answer_variants.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer_variants.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, text TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE test_question (id UUID NOT NULL, question_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_239442181E27F6BF ON test_question (question_id)');
        $this->addSql('COMMENT ON COLUMN test_question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN test_question.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE test_session (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN test_session.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE test_session_test_question (test_session_id UUID NOT NULL, test_question_id UUID NOT NULL, PRIMARY KEY(test_session_id, test_question_id))');
        $this->addSql('CREATE INDEX IDX_8FAC93251A0C5AE6 ON test_session_test_question (test_session_id)');
        $this->addSql('CREATE INDEX IDX_8FAC932541594D01 ON test_session_test_question (test_question_id)');
        $this->addSql('COMMENT ON COLUMN test_session_test_question.test_session_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN test_session_test_question.test_question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2554E42191 FOREIGN KEY (answer_variant_id) REFERENCES answer_variants (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2541594D01 FOREIGN KEY (test_question_id) REFERENCES test_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_variants ADD CONSTRAINT FK_94D252841E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_question ADD CONSTRAINT FK_239442181E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_session_test_question ADD CONSTRAINT FK_8FAC93251A0C5AE6 FOREIGN KEY (test_session_id) REFERENCES test_session (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_session_test_question ADD CONSTRAINT FK_8FAC932541594D01 FOREIGN KEY (test_question_id) REFERENCES test_question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A2554E42191');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A2541594D01');
        $this->addSql('ALTER TABLE answer_variants DROP CONSTRAINT FK_94D252841E27F6BF');
        $this->addSql('ALTER TABLE test_question DROP CONSTRAINT FK_239442181E27F6BF');
        $this->addSql('ALTER TABLE test_session_test_question DROP CONSTRAINT FK_8FAC93251A0C5AE6');
        $this->addSql('ALTER TABLE test_session_test_question DROP CONSTRAINT FK_8FAC932541594D01');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE answer_variants');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE test_question');
        $this->addSql('DROP TABLE test_session');
        $this->addSql('DROP TABLE test_session_test_question');
    }
}
