<?php

namespace common\enum;

/**
 * Class Status
 * @package common\enum
 */
class Status
{
    const ENABLED = 1;
    const DISABLED = -1;

    /**
     * @var array
     */
    public static $list = [
        self::ENABLED   => '显示',
        self::DISABLED  => '隐藏',
    ];
}
