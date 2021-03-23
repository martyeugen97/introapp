<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use app\models\Order;

/**
 * This is the model class for order search.
 */

class OrderSearch extends Model
{
    public $searchType;
    public $search;
    public $status;
    public $mode;
    public $service_id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['searchType', 'number', 'min' => 1, 'max' => 3],
            ['search', 'string', 'length' => [1, 128]],
            ['status', 'number', 'min' => 0, 'max' => 4],
            ['mode', 'number', 'min' => 0, 'max' => 1],
            ['service_id', 'number']
        ];
    }

    public function setParams($params)
    {
        $this->searchType = $params['search-type'];
        $this->search = $params['search'];
        $this->status = $params['status'];
        $this->mode = $params['mode'];
        $this->service_id = $params['service_id'];
    }

    /**
     * @return array search orders and add status
     */

    public function filter()
    {
        $orders = $this->search();
        if (isset($this->status)) {
            $orders = $orders->andWhere(['status' => $this->status]);
        }
        if (isset($this->mode)) {
            $orders = $orders->andWhere(['mode' => $this->mode]);
        }
        if (isset($this->service_id)) {
            $orders = $orders->andWhere(['service_id' => $this->service_id]);
        }

        return $orders;
    }

    /**
     * @return array search orders
     */
    private function search()
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
        return Order::find()->select('o.*')
            ->from('orders o')
            ->leftJoin('users u', 'o.user_id = u.id')
            ->where("CONCAT(`first_name`, ' ', `last_name`) LIKE '%${name}%'");
    }
}