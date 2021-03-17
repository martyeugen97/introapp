<?php


namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

class Order extends ActiveRecord
{
    private const statusArray = ['Pending', 'In progress', 'Completed', 'Canceled', 'Error'];
    private const modeArray = ['Auto', 'Manual'];
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
        return self::statusArray[$this->status];
    }

    /**
     * @return string[] return array of statuses;
     */

    public static function getAllStatuses()
    {
        return self::statusArray;
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
        return self::modeArray[$this->mode];
    }
}
