<?php


namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public $link;
    public $quantity;
    public $status;
    public $mode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['link', 'quantity', 'status', 'mode'], 'required'],
            // email has to be a valid email address
            ['link', 'url'],
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
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [];
    }

    public function totalOrders()
    {

    }
}
