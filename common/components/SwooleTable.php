<?php
namespace common\components;

use swoole_table;

/**
 * Swoole 内存表
 *
 * Class SwooleTable
 * @package common\components
 */
class SwooleTable
{
    protected $_tables;

    /**
     * 设置内存表
     *
     * @param $table
     * @return mixed
     */
    public function table($table)
    {
        return $this->_table = $table;
    }

    public function create($table, $int, array $column)
    {
        $this->_table = new swoole_table($int);
    }

    /**
     * 数据表定义
     *
     * $arr = [
     *      'key' => 'keys',
     *      'type' => 'string',
     *      'len' => 65536
     * ];
     * @param $table
     * @param $arr
     */
    private function column($table, $arr)
    {
        $allType = [
            'int'       => swoole_table::TYPE_INT,
            'string'    => swoole_table::TYPE_STRING,
            'float'     => swoole_table::TYPE_FLOAT
        ];

        foreach ($arr as $row)
        {
            if (!isset($allType[$row['type']]))
            {
                $row['type'] = 'string';
            }

            $table->column($row['key'], $allType[$row['type']], $row['len']);
        }
    }
}