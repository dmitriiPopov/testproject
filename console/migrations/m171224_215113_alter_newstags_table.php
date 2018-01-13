<?php

use yii\db\Migration;

class m171224_215113_alter_newstags_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        // TODO: НИКОГДА НЕ УКАЗЫВАЙ базы данных в запросах, если они могут отличаться у других разработчиков
        $this->execute("
            ALTER TABLE `news_tags`
            DROP FOREIGN KEY `fk_news_newstags`,
            DROP FOREIGN KEY `fk_tags_newstags`;
            ALTER TABLE `news_tags`
            ADD CONSTRAINT `fk_news_newstags`
              FOREIGN KEY (`news_id`)
              REFERENCES `news` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_tags_newstags`
              FOREIGN KEY (`tag_id`)
              REFERENCES `tags` (`id`)
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
