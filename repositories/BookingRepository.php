<?php

namespace app\repositories;

use app\models\Booking;
use RuntimeException;
use yii\db\Exception;

class BookingRepository
{
    public function getBookings(int $participantId): ?array
    {
        return Booking::find()->where(['inviter' => $participantId])->all();
    }

    public function get(int $bookingId): Booking
    {
        if (!$booking = Booking::find()->where(['id' => $bookingId])->one()) {
            throw new Exception('Booking not found.');
        }
        return $booking;
    }

    public function save(Booking $booking)
    {
        if (!$booking->save()) {
            $err = $booking->getFirstErrors();
            throw new RuntimeException("Booking save error: " . reset($err));
        }
    }
}