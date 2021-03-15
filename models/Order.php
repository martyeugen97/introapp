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
        $statusArray = ['Pending', 'In progress', 'Completed', 'Canceled', 'Error'];
        return $statusArray[$this->status];
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
        $modeArray = ['Auto', 'Manual'];
        return $modeArray[$this->mode];
    }

}
