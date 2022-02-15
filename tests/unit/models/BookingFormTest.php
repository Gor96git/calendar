<?php

namespace tests\unit\models;

use app\fixtures\BookingFixture;
use app\fixtures\UserFixture;
use app\models\Booking;
use app\models\BookingForm;
use app\services\BookingService;
use yii\di\Instance;

class BookingFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public \UnitTester $tester;



    public function testBookingForm()
    {
        $model = new BookingForm(null,[
            'participant' => 1,
            'inviter' => 2,
            'date_start' => strtotime('+2 hour'),
            'date_end' => strtotime('+6 hour'),
        ]);

        assert($model->validate());
        $service = Instance::ensure(BookingService::class);
        expect($service->add($model))->isInstanceOf(Booking::class);

    }


    public function testBookingFormNotValidate()
    {
        $model = new BookingForm();

        $model->attributes = [
            'participant' => 2,
            'inviter' => 2,
            'date_start' => strtotime('-2 hour'),
            'date_end' => strtotime('-2 hour'),
        ];

        expect_not($model->validate());
        expect($model->errors)->hasKey('date_end');
        expect($model->errors)->hasKey('date_start');
        expect($model->errors)->hasKey('date_end');
        expect($model->errors)->hasKey('participant');

    }
}
