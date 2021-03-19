<?php


namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

class Order extends ActiveRecord
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['status', 'number', 'min' => 0, 'max' => 4],
            ['mode', 'number', 'min' => 0, 'max' => 1],
            ['service_id', 'number']
        ];
    }

    public function setParams($params)
    {
        $this->status = $params['status'];
        $this->mode = $params['mode'];
        $this->service_id = $params['service_id'];
    }

    public function filter()
    {
        $where = array();
        if (isset($this->status)) {
            $where['status'] = $this->status;
        }
        if (isset($this->mode)) {
            $where['mode'] = $this->mode;
        }
        if (isset($this->service_id)) {
            $where['service_id'] = $this->service_id;
        }
        return Order::find()->where($where);
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{orders}}';
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return self::STATUS_ARRAY[$this->status];
    }

    /**
     * @return string[] return array of statuses;
     */

    public static function getAllStatuses()
    {
        return self::STATUS_ARRAY;
    }

    /**
     * @return string
     */
    public function getCreatedTime()
    {
        return date("H:i:s", $this->created_at);
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return date("Y-m-d", $this->created_at);
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return self::MODE_ARRAY[$this->mode];
    }
}
