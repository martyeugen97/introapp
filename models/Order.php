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
        return [];
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
