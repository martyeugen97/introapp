<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $order = new Order();
        $requestParams = Yii::$app->request->get();
        $order->load($requestParams);
        if (!$order->validate()) {
            throw new BadRequestHttpException();
        }

        $orders = Order::find()->where($requestParams);
        $pages = new Pagination(['totalCount' => $orders->count()]);
        $pages->pageSize = 100;
        $orders = $orders
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $requestParams = array_map('intval', $requestParams);
        return $this->render('index', [
            'orders' => $orders,
            'pages' => $pages,
            'status' => $requestParams['status'],
            'mode' =>  $requestParams['mode'],
            'service_id' => $requestParams['service_id'],
        ]);

    }

    /**
     * Search orders
     *
     * @return string
     */
    public function actionSearch()
    {
        die('');
        $orderSearch = new OrderSearch();
        $requestParams = Yii::$app->request->get();
        $orderSearch->load($requestParams);
        if (!$orderSearch->validate()) {
            throw new BadRequestHttpException();
        }

        $orders = $orderSearch->search($requestParams['search-type'], $requestParams['search']);
        //$pages = new Pagination(['totalCount' => count($orders)]);
        //$pages->pageSize = 100;
        /*
        return $this->render('index', [
            'orders' => $orders,
            'pages' => $pages,
            'search-type' => $requestParams['search-type'],
            'search' => $requestParams['search'],
        ]);
        */

        return print_r($orders, true);
    }
}
