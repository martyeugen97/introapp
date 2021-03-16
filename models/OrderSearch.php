<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Order;

class OrderSearch extends Model
{
    public $searchType;
    public $search;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['searchType', 'required'],
            ['search', 'required'],
        ];
    }

    /**
     * @return array search orders
     */
    public function search()
    {
        switch ($this->searchType) {
            case 1:
                return self::searchOrderId($this->search);
            case 2:
                return self::searchLink($this->search);

            default:
                return Order::find();
        }
    }

    private static function searchOrderId($id)
    {
        return Order::find()->where(compact('id'));
    }

    private static function searchLink($link)
    {
        return Order::find()->where('link LIKE :link', [':link' => '%' . addslashes($link) . '%']);
    }

    private static function searchName($name)
    {
        $names = explode(' ', addslashes($name));
    }
}