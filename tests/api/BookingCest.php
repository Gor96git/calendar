<?php

use Codeception\Util\HttpCode;
use app\models\Booking;

class BookingCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public function getBook(ApiTester $I)
    {
        $I->amBearerAuthenticated('PBXIPGVkWxQJySVBdHRMAQZJz1-kIEgu');
        $I->sendGet('books/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type": "object"}');
        $validResponseJsonSchema = json_encode(
            [
                "properties" => [
                    'id' => ['type' => 'integer'],
                    'inviter' => ['type' => 'integer'],
                    'participant' => ['type' => 'integer'],
                    'date_start' => ['type' => 'integer'],
                    'date_end' => ['type' => 'integer']

                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function createNewBook(ApiTester $I)
    {
        $I->amBearerAuthenticated('PBXIPGVkWxQJySVBdHRMAQZJz1-kIEgu');
        $I->sendPost(
            'books',
            [
                'inviter' => 1,
                'participant' => 2,
                'date_start' => strtotime('+2 hour'),
                'date_end' => strtotime('+6 hour'),
            ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'id' => 'integer',
                'inviter' => 'integer',
                'participant' => 'integer',
                'date_start' => 'integer',
                'date_end' => 'integer'
            ]
        );
    }

}
