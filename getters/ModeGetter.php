<?php


namespace app\getters;


class ModeGetter
{
    private const MODE_ARRAY = [
        'panel.label.mode_auto',
        'panel.label.mode_manual'
    ];

    /**
     *  @return array
     *  Lists all modes
     **/
    public static function getList()
    {
        return self::MODE_ARRAY;
    }

    /**
     *  @return string
     *  Returns a mode by id
     **/
    public static function get($id)
    {
        return self::MODE_ARRAY[$id];
    }
}