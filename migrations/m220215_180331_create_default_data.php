<?php

use yii\db\Migration;

/**
 * Class m220215_180331_create_default_data
 */
class m220215_180331_create_default_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand()->insert('users', [
                'username' => 'test',
                'password_hash' => '$2y$05$mVGoH9fLSgyezONJE.qM1eNtXyw712D2rnKo9e5q4S0mH0RBZEYM.',
                'access_token' => 'PBXIPGVkWxQJySVBdHRMAQZJz1-kIEgu',
                'created_at' => time(),
                'updated_at' => time()
            ]
        )->execute();;
        $inviter = $this->db->lastInsertID;
        $this->db->createCommand()->insert('users', [
                'username' => 'test2',
                'password_hash' => '$2y$05$mVGoH9fLSgyezONJE.qM1eNtXyw712D2rnKo9e5q4S0mH0RBZEYM.',
                'access_token' => 'yJ9KhjYG9xyluTHUXo-FDv09z7aiLAxe',
                'created_at' => time(),
                'updated_at' => time()
            ]
        )->execute();;
        $participant = $this->db->lastInsertID;

        $this->db->createCommand()->insert('bookings', [
                'inviter' => $inviter,
                'participant' => $participant,
                'date_start' => strtotime('+1 day'),
                'date_end' => strtotime('+1 day +3 hour'),
            ]
        )->execute();;
        $this->db->createCommand()->insert('bookings', [
                'inviter' => $participant,
                'participant' => $inviter,
                'date_start' => strtotime('+1 day +5 hour'),
                'date_end' => strtotime('+1 day +9 hour'),
            ]
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220215_180331_create_default_data cannot be reverted.\n";
    }

}
