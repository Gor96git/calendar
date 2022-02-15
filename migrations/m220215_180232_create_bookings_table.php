<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bookings}}`.
 */
class m220215_180232_create_bookings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bookings', [
            'id' => $this->primaryKey(),
            'inviter' => $this->integer()->notNull(),
            'participant' => $this->integer()->notNull(),
            'date_start' => $this->integer()->notNull()->unsigned(),
            'date_end' => $this->integer()->notNull()->unsigned()
        ]);
        $this->addForeignKey('fk-bookings_user_inviter', 'bookings', 'inviter', 'users', 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-bookings_user_participant', 'bookings', 'participant', 'users',
            'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-bookings_user_inviter', 'bookings');
        $this->dropForeignKey('fk-bookings_user_participant', 'bookings');
        $this->dropTable('{{%bookings}}');
    }
}
