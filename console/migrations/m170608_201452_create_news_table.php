<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m170608_201452_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `news` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `imagefile` varchar(255) NOT NULL,
              `category_id` int(10) unsigned NOT NULL,
              `title` varchar(127) NOT NULL DEFAULT '',
              `description` varchar(255) NOT NULL DEFAULT '',
              `content` text,
              `status` enum('new','publicate','published') DEFAULT 'new',
              `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `display` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '''aggregated flag''',
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NULL DEFAULT NULL,
              `public_at` timestamp NULL DEFAULT NULL,
              `published_at` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_news_1_idx` (`category_id`),
              KEY `fk_news_title_idx` (`title`),
              CONSTRAINT `fk_news_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of topics';
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
