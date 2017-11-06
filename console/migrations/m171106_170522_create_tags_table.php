<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 */
class m171106_170522_create_tags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("        
        
            CREATE TABLE `tags` (
              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(127) NOT NULL DEFAULT '' COMMENT 'varchar - text data, not long (127)',
              `enabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'int - 0 or 1',
              `display` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'int - 0 or 1',
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time data',
              `updated_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'time data',
              INDEX `Primary key` (`id` ASC),
              INDEX `Name key` (`name` ASC),
              PRIMARY KEY (`id`))
            ENGINE = InnoDB
            DEFAULT CHARACTER SET = utf8
            COMMENT = 'List of tags for news';
        
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        //$this->dropTable('tags');
        echo 'm171106_170522_create_tags_table cannot be reverted.\n';
        return false;
    }
}
