<?php


namespace app\getters;

use app\models\Service;

class ServiceGetter
{
    /**
     *  @return array
     *  Get all services
     **/
    public static function getList()
    {
        return Service::find()->all();
    }

    /**
     *  @return ?Order
     *  Get service by ID or null
     **/
    public static function get($id)
    {
        return Service::findOne($id);
    }

    /**
     *  @return int
     *  Returns the number of services
     **/
    public static function getCount()
    {
        return Service::find()->count();
    }
}