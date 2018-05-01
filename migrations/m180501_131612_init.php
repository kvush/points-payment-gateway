<?php

use yii\db\Migration;

/**
 * Class m180501_131612_init
 */
class m180501_131612_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'balance' => $this->money(10, 2)->notNull(),
        ], null);

        $this->createTable('{{%transfers}}', [
            'id' => $this->primaryKey(),
            'id_from' => $this->integer()->notNull(),
            'id_to' => $this->integer()->notNull(),
            'amount' => $this->money(10, 2)->notNull(),
        ], null);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transfers}}');
        $this->dropTable('{{%user}}');
    }
}
