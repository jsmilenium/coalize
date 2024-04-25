<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m240424_235622_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'cpf' => $this->string(11)->notNull()->unique(),
            'address' => $this->string(255)->notNull(),
            'number' => $this->integer()->notNull(),
            'city' => $this->string(255)->notNull(),
            'state' => $this->string(2)->notNull(),
            'complement' => $this->string(50),
            'photo' => $this->string(255),
            'gender' => $this->char(1)->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }
}
