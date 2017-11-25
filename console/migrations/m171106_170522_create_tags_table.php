<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 *
 * Often should create one migration for one task.
 */
class m171106_170522_create_tags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("        
        
            CREATE TABLE IF NOT EXISTS `tags` (
              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(127) NOT NULL DEFAULT '' COMMENT 'title of tag',
              `enabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'switcher off/on',
              `display` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'aggregated marker for publishing record',
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime when record has been created',
              `updated_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'datetime when record has been updated',
              INDEX `Primary key` (`id` ASC),
              INDEX `Name key` (`name` ASC),
              PRIMARY KEY (`id`))
            ENGINE = InnoDB
            DEFAULT CHARACTER SET = utf8
            COMMENT = 'List of tags for news';
        
        ");


        //create table
        $this->createTable('news_tags', [
            'id'         => $this->primaryKey(11)->notNull()->unsigned(),
            'news_id'    => $this->integer(10)->notNull()->unsigned(),
            'tag_id'     => $this->integer(11)->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        //create indexes
        $this->createIndex('idx_tag_key', 'news_tags', 'tag_id');
        $this->createIndex('idx_news_key', 'news_tags', 'news_id');
        //create FK
        $this->addForeignKey('fk_news_newstags', 'news_tags', 'news_id', 'news', 'id');
        $this->addForeignKey('fk_tags_newstags', 'news_tags', 'tag_id', 'tags', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news_tags');

        $this->execute("DROP TABLE IF EXISTS `tags`");
    }
}
