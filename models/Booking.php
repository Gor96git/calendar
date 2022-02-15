<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @property-write \app\models\BookingForm $data
 * @property-read User[] $participants
 * @property-read User $participant
 * @property-read User $inviter
 * @property int $id [int(11)]
 * @property int $date_end [int(11) unsigned]
 * @property int $date_start [int(11) unsigned]
 */
class Booking extends ActiveRecord
{

    public static function tableName()
    {
        return 'bookings';
    }


    public function setData(BookingForm $bookingForm)
    {
        $this->setAttributes($bookingForm->toArray(), false);
    }

    public static function create():self
    {
        return new self();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'participant']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'participant']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInviter(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'inviter']);
    }
}