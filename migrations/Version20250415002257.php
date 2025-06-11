<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415002257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, subscribed_at DATETIME NOT NULL, INDEX IDX_7E8585C8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address DROP FOREIGN KEY FK_D4E6F815F7BFDD2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D4E6F815F7BFDD2 ON address
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD country VARCHAR(100) NOT NULL, DROP nno_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD variant_id INT NOT NULL, ADD quantity INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25273B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F0FE25273B69A9AF ON cart_item (variant_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD shipping_address_id INT NOT NULL, ADD payment_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES address (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F52993984C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F52993984D4CFF2B ON `order` (shipping_address_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F52993984C3A3BB ON `order` (payment_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD order_id INT NOT NULL, ADD amount NUMERIC(10, 2) NOT NULL, ADD status VARCHAR(50) NOT NULL, ADD transaction_id VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6D28840D8D9F6D38 ON payment (order_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX user_product_unique ON review (user_id, product_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C8A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE newsletter
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD nno_id INT DEFAULT NULL, DROP country
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD CONSTRAINT FK_D4E6F815F7BFDD2 FOREIGN KEY (nno_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D4E6F815F7BFDD2 ON address (nno_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25273B69A9AF
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_F0FE25273B69A9AF ON cart_item
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP variant_id, DROP quantity
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984D4CFF2B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984C3A3BB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_F52993984D4CFF2B ON `order`
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_F52993984C3A3BB ON `order`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP shipping_address_id, DROP payment_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D8D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_6D28840D8D9F6D38 ON payment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment DROP order_id, DROP amount, DROP status, DROP transaction_id
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX user_product_unique ON review
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP is_verified
        SQL);
    }
}
