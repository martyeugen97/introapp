<?php


namespace app\getters;


class ModeGetter
{
    private const MODE_ARRAY = [
        'panel.label.mode_auto',
        'panel.label.mode_manual'
    ];

    public static function getList(): array
    {
        return self::MODE_ARRAY;
    }

    public static function get($id): string
    {
        return self::MODE_ARRAY[$id];
    }
}