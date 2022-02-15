<?php

namespace app\controllers;

use app\models\Booking;
use app\models\BookingForm;
use app\models\User;
use app\repositories\BookingRepository;
use app\services\BookingService;
use Yii;
use yii\base\Model;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class BookController extends Controller
{
    private BookingService $bookingService;
    private BookingRepository $bookingRepository;

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $module, BookingService $bookingService, BookingRepository $bookingRepository, $config = [])
    {
        $this->bookingService = $bookingService;
        $this->bookingRepository = $bookingRepository;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
     $access = [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','create','update','get','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'index' => ['get'],
                    'get' => ['get'],
                    'create' => ['post'],
                    'update' => ['patch'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(),
            ['bearerAuth' => [
                'class' => HttpBearerAuth::class,
                'except' => ['login']
            ]],$access
        );
    }

    /**
     * @return Booking[]|null
     */
    public function actionIndex(): ?array
    {
        return $this->bookingRepository->getBookings(Yii::$app->user->identity->getId());
    }

    /**
     * @return Model
     */
    public function actionCreate(): Model
    {
        $bookingForm = new BookingForm();
        $bookingForm->load(Yii::$app->request->post(), '');
        if ($bookingForm->validate()) {
            return $this->bookingService->add($bookingForm);
        }
        return $bookingForm;
    }

    /**
     * @param int $id
     * @return Model
     * @throws \yii\db\Exception
     */
    public function actionUpdate(int $id): Model
    {
        $bookingForm = new BookingForm($this->bookingRepository->get($id));
        $bookingForm->load(Yii::$app->request->post(), '');
        if ($bookingForm->validate()) {
            return $this->bookingService->edit($bookingForm);
        }
        return $bookingForm;
    }

    /**
     * @param int $id
     * @return Booking
     * @throws \yii\db\Exception
     */
    public function actionGet(int $id): Booking
    {
        return $this->bookingRepository->get($id);
    }

    /**
     * @return array
     * TODO add login form validation
     */
    public function actionLogin()
    {
        $user = User::findByUsername(\Yii::$app->request->post('username'));
        $user->generateAuthKey();
        $user->save($user);
        return [
            'auth_key' => $user->getAuthKey()
        ];
    }


}
