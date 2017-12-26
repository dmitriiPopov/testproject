<?php

use yii\db\Migration;

class m171224_215113_alter_newstags_table extends Migration
{
//    public function safeUp()
//    {
//
//    }
//
//    public function safeDown()
//    {
//        echo "m171224_215113_alter_newstags_table cannot be reverted.\n";
//
//        return false;
//    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->execute("
            ALTER TABLE `testadvanced`.`news_tags` 
            DROP FOREIGN KEY `fk_news_newstags`,
            DROP FOREIGN KEY `fk_tags_newstags`;
            ALTER TABLE `testadvanced`.`news_tags` 
            ADD CONSTRAINT `fk_news_newstags`
              FOREIGN KEY (`news_id`)
              REFERENCES `testadvanced`.`news` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_tags_newstags`
              FOREIGN KEY (`tag_id`)
              REFERENCES `testadvanced`.`tags` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE;
        ");
    }

    public function down()
    {
        echo "m171224_215113_alter_newstags_table cannot be reverted.\n";

        return false;
    }
}
