<?php
namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 生成数据字典
 *
 * Class DataDictionaryHelper
 * @package common\helpers
 */
class DataDictionaryHelper
{
    protected $_tables;

    protected $_tableSchemas;

    /**
     * DataDictionaryHelper constructor.
     * @throws \yii\db\Exception
     */
    public function __construct()
    {
        // 获取全部表结构信息
        $tableSchema = Yii::$app->db->schema->getTableSchemas();
        $tableSchema = ArrayHelper::toArray($tableSchema);

        // 获取全部表信息
        $tables  = Yii::$app->db->createCommand('SHOW TABLE STATUS')->queryAll();
        $this->_tables  = array_map('array_change_key_case', $tables);

        $list = [];
        foreach ($tableSchema as $item)
        {
            $key = $item['name'];

            $list[$key]['table_name'] = $key;// 表名
            $list[$key]['item'] = [];

            foreach ($item['columns'] as $column)
            {
                $tmpArr = [];
                $tmpArr['name'] = $column['name']; // 字段名称
                $tmpArr['type'] = $column['dbType']; // 类型
                $tmpArr['defaultValue'] = $column['defaultValue']; // 默认值
                $tmpArr['comment'] = $column['comment']; // 注释
                $tmpArr['isPrimaryKey'] = $column['isPrimaryKey']; // 是否主键
                $tmpArr['autoIncrement'] = $column['autoIncrement']; // 是否自动增长
                $tmpArr['unsigned'] = $column['unsigned']; // 是否无符号
                $tmpArr['allowNull'] = $column['allowNull']; // 是否允许为空

                $list[$key]['item'][] = $tmpArr;
                unset($tmpArr);
            }
        }

        $this->_tableSchemas = $list;
    }

    /**
     * 生成数据字典
     *
     */
    public function getMarkTableData()
    {
        $data = $this->_tableSchemas;
        $tables = $this->_tables;

        $str = '';
        $i = 0;
        foreach ($data as $key => $datum)
        {
            $table_comment = $tables[$i]['comment'];

            $str .= "### {$table_comment}" . "\n";
            $str .= "### {$key}" . "\n\r";
            $str .= "字段 | 类型 | 允许为空 | 默认值 | 字段说明" . "\n";
            $str .= "---|---|---|---|---" . "\n";

            foreach ($datum['item'] as $item)
            {
                empty($item['comment']) && $item['comment'] = "无";
                $item['allowNull'] = !empty($item['allowNull']) ? "是" : '否';
                $str .= "{$item['name']} | {$item['type']} | {$item['allowNull']} | {$item['defaultValue']} | {$item['comment']}" . "\n";
            }

            $str .= "\r";
            $i++;
        }

        echo "<pre>";
        echo $str;
        exit();
    }
}