<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180203171424 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, player_a_id INT DEFAULT NULL, player_b_id INT DEFAULT NULL, score_a INT NOT NULL, score_b INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7A5BC50599C4036B (player_a_id), INDEX IDX_7A5BC5058B71AC85 (player_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC50599C4036B FOREIGN KEY (player_a_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5058B71AC85 FOREIGN KEY (player_b_id) REFERENCES player (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `match`');
    }
}
