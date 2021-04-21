<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m210419_190054_create_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rate}}', [
            'id' => $this->primaryKey(),
            'currency' => $this->string(10),
            'buy' => $this->decimal(10,2),
            'sell' => $this->decimal(10,2),
            'begins_at' => $this->timestamp(),
            'office_id' => $this->string()->defaultValue(null),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);

        $this->createIndex('idx-office-begins-currency', 'rate', ['office_id', 'begins_at', 'currency']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-office-begins-currency', 'rate');
        $this->dropTable('{{%rate}}');
    }
}
