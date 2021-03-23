<?php


namespace app\models;

use yii\db\ActiveRecord;

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
     * Format created at, return only time
     * @return string
     */
    public function getCreatedTime()
    {
        return date("H:i:s", $this->created_at);
    }

    /**
     * Format created at, return only date
     * @return string
     */
    public function getCreatedDate()
    {
        return date("Y-m-d", $this->created_at);
    }
}
