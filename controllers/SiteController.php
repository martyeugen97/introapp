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
        $params = Yii::$app->request->get();
        if (isset($params['search'])) {
            $model = new OrderSearch();
            $model->searchType = $params['search-type'];
            $model->search = $params['search'];
            if (!$model->validate()) {
                throw new BadRequestHttpException();
            }
            $orders = $model->search();
        } else {
            $model = new Order();
            $model->load($params);
            if (!$model->validate()) {
                throw new BadRequestHttpException();
            }
            $orders = Order::find()->where($params);
            $params = array_map('intval', $params);
        }

        $pages = new Pagination(['totalCount' => $orders->count()]);
        $pages->pageSize = 100;
        $orders = $orders->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('orders', 'pages', 'params'));
    }

}
