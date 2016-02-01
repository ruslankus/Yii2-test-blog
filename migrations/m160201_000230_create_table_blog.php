<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_000230_create_table_blog extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160201_000230_create_table_blog cannot be reverted.\n";

        return false;
    }
    */


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `blg_blog` (
               `id` INT NOT NULL AUTO_INCREMENT,
              `user_id` INT NOT NULL,
              `description` VARCHAR(255) NOT NULL,
              `article` TEXT NOT NULL,
              `create_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              INDEX `fk_blg_blog_1_idx` (`user_id` ASC),
              CONSTRAINT `fk_blg_blog_1`
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
            DROP TABLE IF EXISTS `blg_blog`;
        ");
    }

}
