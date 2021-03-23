<?php


namespace app\getters;

use app\models\Service;
use yii\db\BaseActiveRecord;

class ServiceGetter
{
    /**
     * @return array
     * Get all services
     **/
    public static function getList()
    {
        return Service::find()->all();
    }

    /**
     * Get service by ID or null
     * @return BaseActiveRecord
     **/
    public static function get($id)
    {
        return Service::findOne($id);
    }

    /**
     * Returns the number of services
     * @return int
     **/
    public static function getCount()
    {
        return Service::find()->count();
    }
}