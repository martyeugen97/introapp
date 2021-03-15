<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Order;

class OrderSearch extends Model
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['search-type', 'required', 'number', 'min' => 1, 'max' => 3],
            ['search', 'required', 'string', 'min' => 1, 'max' => 128],
        ];
    }

    /**
     * @return array search orders
     */
    public function search($type, $search)
    {
        switch ($type) {
            case 1:
                return $this->searchOrderId($search);
            case 2:
                return $this->searchLink($search);
            case 3:
                return [];

            default:
                return [];
        }
    }

    private function searchOrderId($id)
    {
        return [ Order::findOne($id) ];
    }

    private function searchLink($link)
    {
        return Order::find()->where('link LIKE :link', [':link' => '%' . addslashes($link) . '%']);
    }

    private function searchName($name)
    {
        $names = explode(' ', addslashes($name));
    }
}