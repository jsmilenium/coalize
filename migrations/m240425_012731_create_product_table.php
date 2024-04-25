<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240425_012731_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'name' => $this->string(80)->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'photo' => $this->string(255),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-product-customer_id',
            'product',
            'customer_id',
            'customer',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
