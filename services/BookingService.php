<?php
declare(strict_types=1);

namespace app\services;

use app\models\Booking;
use app\models\BookingForm;
use app\repositories\BookingRepository;
use Codeception\Util\HttpCode;

class BookingService
{
    private BookingRepository $repository;

    /**
     * BookingService constructor.
     * @param BookingRepository $repository
     */
    public function __construct(BookingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BookingForm $bookingForm
     * @return Booking
     */
    public function add(BookingForm $bookingForm): Booking
    {
        $book = new Booking();
        $data = $this->fillBook($book, $bookingForm);
        \Yii::$app->response->setStatusCode(HttpCode::CREATED);
        return $data;
    }

    /**
     * @param BookingForm $bookingForm
     * @return Booking
     */
    public function edit(BookingForm $bookingForm): Booking
    {
        $book = $bookingForm->getBooking();
        return $this->fillBook($book, $bookingForm);
    }

    /**
     * @param Booking $book
     * @param BookingForm $bookingForm
     * @return Booking
     */
    private function fillBook(Booking $book, BookingForm $bookingForm): Booking
    {
        $book->setData($bookingForm);
        $this->repository->save($book);
        return $book;
    }
}