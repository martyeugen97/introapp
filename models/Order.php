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
