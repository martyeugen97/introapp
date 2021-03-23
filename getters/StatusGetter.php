<?php


namespace app\getters;

class StatusGetter
{
    private const STATUS_ARRAY = [
        'panel.label.status_pending',
        'panel.label.status_in_progress',
        'panel.label.status_completed',
        'panel.label.status_canceled',
        'panel.label.status_error'
    ];

    /**
     * Lists all statuses
     * @return array
     **/
    public static function getList()
    {
        return self::STATUS_ARRAY;
    }

    /**
     * @return string
     * @params int
     **/
    public static function get($id)
    {
        return self::STATUS_ARRAY[$id];
    }
}
