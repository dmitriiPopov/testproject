<?php

use yii\db\Migration;

class m170518_204744_admin_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->execute($this->addUserSql());
    }

    public function down()
    {
//        echo "m170518_204744_admin_user cannot be reverted.\n";
        $this->dropTable('{{%admin_user}}');
//        return false;
    }

    private function addUserSql()
    {
        $password = Yii::$app->security->generatePasswordHash('superadmin');
        $auth_key = Yii::$app->security->generateRandomString();
        $token = Yii::$app->security->generateRandomString() . '_' . time();
        $created = time();
        $update = $created;
        return "INSERT INTO {{%admin_user}} (`username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `created_at`, `updated_at`) VALUES ('superadmin', '$auth_key', '$password', '$token', 'superadmin@mail.loc', '$created', '$update')";
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
