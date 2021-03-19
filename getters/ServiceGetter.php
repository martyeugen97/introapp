<?php


namespace app\getters;

use app\models\Service;

class ServiceGetter
{
    public static function getList(): array
    {
        return Service::find()->all();
    }

    public static function get($id): ?Order
    {
        return Service::findOne($id);
    }

    public static function getCount(): int
    {
        return Service::find()->count();
    }
}