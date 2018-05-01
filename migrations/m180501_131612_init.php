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

        $this->createIndex(
            'idx-user-name',
            '{{%user}}',
            'name'
        );

        $this->createTable('{{%transfers}}', [
            'id' => $this->primaryKey(),
            'id_from' => $this->integer()->notNull(),
            'id_to' => $this->integer()->notNull(),
            'amount' => $this->money(10, 2)->notNull(),
        ], null);

        $this->createIndex(
            'idx-from-user_id',
            '{{%transfers}}',
            'id_from'
        );

        $this->createIndex(
            'idx-to-user_id',
            '{{%transfers}}',
            'id_to'
        );

        try {
            $this->addForeignKey(
                'fk-from-user_id',
                '{{%transfers}}',
                'id_from',
                '{{%user}}',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-to-user_id',
                '{{%transfers}}',
                'id_to',
                '{{%user}}',
                'id',
                'CASCADE'
            );
        } catch (Exception $e) {
            //nothing do
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropForeignKey(
                'fk-to-user_id',
                '{{%transfers}}'
            );

            $this->dropForeignKey(
                'fk-from-user_id',
                '{{%transfers}}'
            );
        } catch (Exception $e) {
            //nothing do
        }

        $this->dropIndex(
            'idx-to-user_id',
            '{{%transfers}}'
        );

        $this->dropIndex(
            'idx-from-user_id',
            '{{%transfers}}'
        );

        $this->dropTable('{{%transfers}}');

        $this->dropIndex(
            'idx-user-name',
            '{{%user}}'
        );

        $this->dropTable('{{%user}}');
    }
}
