<?php

use yii\db\Migration;

/**
 * Handles the creation of table `markers`.
 */
class m181009_215725_create_markers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `markers` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `latitude` FLOAT(10,6) NOT NULL DEFAULT '50.454660',
                `longitude` FLOAT(10,6) NOT NULL DEFAULT '30.523800',
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`))
            ENGINE = InnoDB
            DEFAULT CHARACTER SET = utf8
            COMMENT = 'List of Markers';
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('markers');
    }
}
