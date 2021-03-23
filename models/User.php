<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // first and last names are required
            [['first_name', 'last_name'], 'required'],
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{users}}';
    }

    /**
     * @return string get full name
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
