<?php

use yii\db\Migration;

/**
 * Class m180225_145630_fix_db
 */
class m180225_145630_fix_db extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // TODO: и не забудь синхронизировать тестовую таблицу в тестовой БД
        $this->execute("
            ALTER TABLE `news`
            CHANGE COLUMN `imagefile` `imagefile` VARCHAR(255) NULL DEFAULT ''
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        //null
    }
}
