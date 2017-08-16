<?php

use yii\db\Migration;

/**
 * Handles adding imagefile to table `user`.
 */
class m170805_132023_add_imagefile_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'imagefile', $this->string(255)->after('username'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'imagefile');
    }
}
