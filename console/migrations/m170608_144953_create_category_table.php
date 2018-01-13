<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170608_144953_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("
        
            CREATE TABLE `category` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL DEFAULT '',
                `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `display` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT ' ''aggregated flag'' ',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='List of categories for news';

        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        //$this->dropTable('category');
        echo 'm170608_144953_create_category_table cannot be reverted.\n';
        return false;
    }
}
