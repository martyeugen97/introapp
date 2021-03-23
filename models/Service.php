<?php

namespace app\models;

use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, is required
            [['name'], 'required'],
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{services}}';
    }

}
