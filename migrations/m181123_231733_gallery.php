<?php

use yii\db\Migration;

/**
 * Class m181123_231733_gallery
 */
class m181123_231733_gallery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
           CREATE TABLE IF NOT EXISTS `gallery` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `thumb_path` VARCHAR(150) NULL,
              `path` VARCHAR(150) NULL,
              `is_main` TINYINT(1) NULL DEFAULT 0,
              `alt` VARCHAR(120) NULL,
              `title` VARCHAR(120) NULL,
              `sort` SMALLINT NULL,
              `assign_id` INT NULL,
              `type` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `ASSIGN` (`assign_id` ASC),
              INDEX `SORT` (`sort` ASC))
            ENGINE = InnoDB
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181123_231733_gallery cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_231733_gallery cannot be reverted.\n";

        return false;
    }
    */
}
