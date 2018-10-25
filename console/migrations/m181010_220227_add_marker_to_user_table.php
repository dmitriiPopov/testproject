<?php

use yii\db\Migration;

/**
 * Class m181010_220227_add_marker_to_user_table
 */
class m181010_220227_add_marker_to_user_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->execute("
            ALTER TABLE `user` 
            ADD COLUMN `marker_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `status`,
            ADD INDEX `fk_user_marker_idx` (`marker_id` ASC);
            ALTER TABLE `user` 
            ADD CONSTRAINT `fk_user_marker`
              FOREIGN KEY (`marker_id`)
              REFERENCES `markers` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE;
        ");
    }

    public function down()
    {
        $this->dropColumn('user', 'marker_id');
    }
}
