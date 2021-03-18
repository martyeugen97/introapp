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
            [['searchType', 'search'], 'required'],
            ['searchType','number', 'min' => 1 ,'max' => 3],
            ['search', 'string', 'min' => 1, 'max' => 128],
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
            case 3:
                return self::searchName($this->search);
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
        $name = addslashes($name);
        $wordCount = count(explode(' ', $name));
        if ($wordCount == 1) {
            $where = "`first_name` LIKE '%${name}%' OR `last_name` LIKE '%${name}%'";
        } elseif ($wordCount == 2) {
            $where = "CONCAT(`first_name`, ' ', `last_name`) = '${name}'";
        } else {
            return Order::find();
        }

        return Order::find()->select('o.*')
            ->from('orders o')
            ->leftJoin('users u', 'o.user_id = u.id')
            ->where($where);
    }
}