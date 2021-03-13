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

        $service_id = $request->get('service_id', 'all');
        if ($service_id != 'all') {
            $service_id = (int)$service_id;
        }

        $type = $request->get('search-type', 'none');
        $search = $request->get('search');

        $query = Order::find();
        switch($type)
        {
            case 1:
                $query = $query->where(['id' => $search]);
                break;
        }

        if (is_numeric($status)) {
            $query = $query->andWhere(compact('status'));
        }

        if (is_numeric($mode)) {
            $query = $query->andWhere(compact('mode'));
        }

        if (is_numeric($service_id)) {
            $query = $query->andWhere(compact('service_id'));
        }

        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->pageSize = 100;        
        $orders = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('orders', 'pages', 'status', 'mode', 'service_id'));
    }
}
