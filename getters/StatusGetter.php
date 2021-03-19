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

    public static function getList(): array
    {
        return self::STATUS_ARRAY;
    }

    public static function get($id): string
    {
        return self::STATUS_ARRAY[$id];
    }
}
