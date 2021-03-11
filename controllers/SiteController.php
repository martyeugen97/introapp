<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;

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
        $request = Yii::$app->request;
        $status = $request->get('status', 'all');
        if ($status != 'all') {
            $status = (int)$status;
        }

        $mode = $request->get('mode', 'all');
        if ($mode != 'all') {
            $mode = (int)$mode;
        }

        $query = Order::find();
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->pageSize = 100;
        $orders = $query->offset($pages->offset);
        if (is_numeric($status)) {
            $orders = $orders->where(compact('status'));
        }

        if (is_numeric($mode)) {
            $orders = $orders->where(compact('mode'));
        }

        $orders = $orders->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('orders', 'pages', 'status', 'mode'));
    }
}
