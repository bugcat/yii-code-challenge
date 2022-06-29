<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m220629_072243_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->defaultValue(''),
            'code' => $this->char(3)->unique(),
            't_status' => "ENUM('ok', 'hold') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'ok'",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%supplier}}');
    }
}
