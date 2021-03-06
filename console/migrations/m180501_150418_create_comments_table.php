<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180501_150418_create_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->execute("
            CREATE TABLE IF NOT EXISTS `comments` (
                    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `user_id` INT(11) NOT NULL,
                    `news_id` INT(10) UNSIGNED NOT NULL,
                    `name` VARCHAR(50) NOT NULL DEFAULT '',
                    `content` TEXT NULL DEFAULT NULL,
                    `enabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                INDEX `fk_comments_news_idx` (`news_id` ASC),
                INDEX `fk_comments_user_idx` (`user_id` ASC),
                CONSTRAINT `fk_comments_news`
                    FOREIGN KEY (`news_id`)
                    REFERENCES `news` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE,
                CONSTRAINT `fk_comments_user`
                    FOREIGN KEY (`user_id`)
                    REFERENCES `user` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE)
                ENGINE = InnoDB
                DEFAULT CHARACTER SET = utf8
                COMMENT = 'List of comments on the news';
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('comments');
    }
}
