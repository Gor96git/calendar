<?php
declare(strict_types=1);

namespace app\models;


use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * Class BookingForm
 * @package app\models
 *
 * @property int $inviter
 * @property int $participant
 * @property int $date_start
 * @property int $date_end
 * @property-read Booking $booking
 */
class BookingForm extends Model
{
    public ?int $inviter = null;
    public ?int $participant = null;
    public ?int $date_start = null;
    public ?int $date_end = null;

    private ?Booking $booking = null;

    public function __construct(Booking $booking = null, $config = [])
    {
        if ($booking) {
            $this->setAttributes($booking->toArray(), false);
            $this->booking = $booking;
        }
        parent::__construct($config);
    }

    public function getBooking(): Booking
    {
        return $this->booking;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['inviter', 'participant', 'date_start', 'date_end'], 'required'],
            ['inviter', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['inviter' => 'id']],
            ['participant', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['participant' => 'id']],
            ['date_start', 'compare', 'operator' => '>=', 'compareValue' => time()],
            ['participant', 'compare', 'operator' => '!==', 'compareAttribute' => 'inviter', 'message' => 'Please, Select another participant'],
            ['date_end', 'compare', 'operator' => '>', 'compareAttribute' => 'date_start'],
            [['date_start', 'date_end'], 'validateAvailability'],

        ];
    }

    public function validateAvailability($attr)
    {
        if ($book = Booking::find()
            ->andWhere(['or', ['inviter' => [$this->inviter, $this->participant]], ['participant' =>
                [$this->inviter, $this->participant]]])
            ->andWhere(['or', ['BETWEEN', 'date_start', $this->date_start, $this->date_end], ['BETWEEN',
                'date_end', $this->date_start, $this->date_end]])->exists()) {
            $this->addError('date',
                "These dates are already booked.");
        }

    }

}
