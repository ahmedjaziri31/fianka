<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430101955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD postal_code VARCHAR(20) NOT NULL, DROP first_name, DROP last_name, DROP zip_code, DROP phone, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD CONSTRAINT FK_D4E6F818D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D4E6F818D9F6D38 ON address (order_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address RENAME INDEX fk_address_user TO IDX_D4E6F81A76ED395
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
            ALTER TABLE newsletter RENAME INDEX idx_newsletter_user TO IDX_7E8585C8A76ED395
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
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491AD5CDBF
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_8D93D6491AD5CDBF ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP cart_id, CHANGE roles roles JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX uniq_identifier_email TO UNIQ_8D93D649E7927C74
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE address MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D4E6F818D9F6D38 ON address
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON address
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD first_name VARCHAR(50) NOT NULL, ADD last_name VARCHAR(50) NOT NULL, ADD phone VARCHAR(20) NOT NULL, CHANGE id id INT NOT NULL, CHANGE postal_code zip_code VARCHAR(20) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address RENAME INDEX idx_d4e6f81a76ed395 TO FK_ADDRESS_USER
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
            ALTER TABLE newsletter RENAME INDEX idx_7e8585c8a76ed395 TO IDX_newsletter_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX user_product_unique ON review
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD cart_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL COLLATE `utf8mb4_bin`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6491AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D6491AD5CDBF ON `user` (cart_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_IDENTIFIER_EMAIL
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
    }
}
