<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_000243_create_table_comments extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160201_000243_create_table_comments cannot be reverted.\n";

        return false;
    }
    */


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->execute("
           CREATE TABLE IF NOT EXISTS `blg_comment` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `user_id` INT NOT NULL,
              `blog_id` INT NOT NULL,
              `comments` VARCHAR(255) NULL,
              `create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              INDEX `fk_blg_comment_1_idx` (`blog_id` ASC),
              INDEX `fk_big_comment_2_idx` (`user_id` ASC, `blog_id` ASC),
              CONSTRAINT `fk_blg_comment_1`
                FOREIGN KEY (`blog_id`)
                REFERENCES `blg_blog` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_big_comment_2`
                FOREIGN KEY (`user_id`)
                REFERENCES `blg_user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ");
    }

    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS `blg_comment` ;
        ");
    }

}
