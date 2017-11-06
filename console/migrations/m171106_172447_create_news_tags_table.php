<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news_tags`.
 */
class m171106_172447_create_news_tags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        //set table options
        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        //create table
        $this->createTable('news_tags', [
            'id'         => $this->primaryKey(11)->notNull()->unsigned(),
            'news_id'    => $this->integer(10)->notNull()->unsigned(),
            'tag_id'     => $this->integer(11)->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
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
        //$this->dropTable('news_tags');
        echo 'm171106_172447_create_news_tags_table cannot be reverted.\n';
        return false;
    }
}
