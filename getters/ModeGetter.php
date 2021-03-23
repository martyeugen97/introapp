<?php


namespace app\getters;

class ModeGetter
{
    private const MODE_ARRAY = [
        'panel.label.mode_auto',
        'panel.label.mode_manual'
    ];

    /**
     * Lists all modes
     * @return array
     **/
    public static function getList()
    {
        return self::MODE_ARRAY;
    }

    /**
     * @return string
     * @params int
     **/
    public static function get($id)
    {
        return self::MODE_ARRAY[$id];
    }
}