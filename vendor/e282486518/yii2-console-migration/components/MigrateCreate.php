<?php

namespace e282486518\migration\components;

use Yii;
use yii\base\Object;
use yii\helpers\FileHelper;
use yii\base\view;

/**
 * 创建Migration文件 
 */
class MigrateCreate extends Object
{
    /**
     * @var $upStr OutputString
     */
    protected $upStr;

    /**
     * @var $downStr OutputString
     */
    protected $downStr;

    /**
     * @var $migrationPath string  默认 migration classes 存储路径.
     */
    public $migrationPath = '@app/migrations';

    /**
     * ---------------------------------------
     * 创建 Migration 表数据和表结构
     * @param $table string 完整表名
     * ---------------------------------------
     */
    public function create($table){
        /* 表结构 Table Structure */
        $this->upStr = new OutputString(['tabLevel' => 2]);
        $this->upStr->addStr('/* 取消外键约束 */');
        $this->upStr->addStr('$this->execute(\'SET foreign_key_checks = 0\');'); //取消外键约束
        $this->upStr->addStr('');//空一行

        $this->generateTableStructure($table);
        $this->upStr->addStr('');//空一行
        $this->generateTableData($table);

        $this->upStr->addStr('');//空一行
        $this->upStr->addStr('/* 设置外键约束 */');
        $this->upStr->addStr('$this->execute(\'SET foreign_key_checks = 1;\');'); //设置外键约束

        /* 删除表 DROP TABLE */
        $this->downStr = new OutputString(['tabLevel' => 2]);
        $this->downStr->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
        if (! empty($table)) {
            $this->downStr->addStr('/* 删除表 */');
            $this->downStr->addStr('$this->dropTable(\'{{%' . $this->getTableName($table) . '}}\');');
        }
        $this->downStr->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');

        /* 生成模板 */
        $path = Yii::getAlias($this->migrationPath);
        if (! is_dir($path)) {
            FileHelper::createDirectory($path);
        }

        $name = 'm' . gmdate('ymd_His') . '_' . $this->getTableName($table);
        $file = $path . DIRECTORY_SEPARATOR . $name . '.php';

        $view = new view();
        $content = $view->renderFile(dirname(__DIR__)."/views/migration.php", [
            'className' => $name,
            'up' => $this->upStr->output()."\n",
            'down' => $this->downStr->output()."\n"
        ]);
        file_put_contents($file, $content);
    }

    /**
     * ---------------------------------------
     * 获取除表前缀的表名称
     * @param $table string 完整表名
     * @return mixed
     * ---------------------------------------
     */
    public function getTableName($table){
        $prefix = \Yii::$app->db->tablePrefix;
        return str_replace($prefix, '', $table);
    }

    /**
     * ---------------------------------------
     * 生成表结构
     * @param $table string 完整表名
     * ---------------------------------------
     */
    public function generateTableStructure($table){
        $tableOption = $this->getTableOption($table);
        $tableSchema = \Yii::$app->db->getTableSchema($table);
        /* 表结构 Table Structure */
        $this->upStr->addStr('/* 创建表 */');
        $this->upStr->addStr('$this->createTable(\'{{%' . $this->getTableName($table) . '}}\', [');

        $this->upStr->tabLevel = 3;
        foreach ($tableSchema->columns as $column) {
            $this->upStr->addStr($this->getTableField($column));
        }

        /* 主键 primary key */
        if (! empty($tableSchema->primaryKey)) {
            $this->upStr->addStr("'PRIMARY KEY (`" . implode("`,`", $tableSchema->primaryKey) . "`)'");
        }

        $this->upStr->tabLevel = 2;
        $this->upStr->addStr('], "' . $tableOption . '");');
        $this->upStr->addStr('');//空一行

        /* 索引 Index */
        $this->upStr->addStr('/* 索引设置 */');
        $tableIndexes = Yii::$app->db->createCommand('SHOW INDEX FROM `' . $table . '`')->queryAll();
        $indexs = [];
        if (is_array($tableIndexes)) {
            foreach ($tableIndexes as $item) {
                /* 过滤主键 */
                if ($item['Key_name'] == 'PRIMARY') {
                    continue;
                }
                if (! isset($indexs[$item["Key_name"]])) {
                    $indexs[$item["Key_name"]] = [];
                    $indexs[$item["Key_name"]]["unique"] = ($item['Non_unique']) ? 0 : 1;
                }
                $indexs[$item["Key_name"]]["columns"][] = $item['Column_name'];
            }
        }
        if (!empty($indexs)) {
            foreach ($indexs as $index => $item) {
                $str = '$this->createIndex(\'' . $index . '\',\'{{%' . $this->getTableName($table) . '}}\',\'' . implode(', ', $item['columns']) . '\',' . $item['unique'] . ');';
                $this->upStr->addStr($str);
            }
        }
        $this->upStr->addStr('');//空一行

        /* 外键约束 Foreign Key */
        $foreignKeys = [];
        if (!empty($tableSchema->foreignKeys)) {
            $this->upStr->addStr('/* 外键约束设置 */');
            $foreignKeyOnDelete = 'CASCADE';
            $foreignKeyOnUpdate = 'CASCADE';
            foreach ($tableSchema->foreignKeys as $fk) {
                $link_table = '';
                foreach ($fk as $k => $v) {
                    if ($k == '0') {
                        $link_table = $v;
                    } else {
                        $link_to_column = $k;
                        $link_column = $v;
                        $str = '$this->addForeignKey(';
                        $str .= '\'fk_' . $this->getTableName($link_table) . '_' . explode('.', microtime('usec'))[1] . '_' . substr("000" . sizeof($foreignKeys), 2) . "',";
                        $str .= '\'{{%' . $this->getTableName($table) . '}}\', ';
                        $str .= '\'' . $link_to_column . '\', ';
                        $str .= '\'{{%' . $this->getTableName($link_table) . '}}\', ';
                        $str .= '\'' . $link_column . '\', ';
                        $str .= '\'' . $foreignKeyOnDelete . '\', ';
                        $str .= '\'' . $foreignKeyOnUpdate . '\' ';
                        $str .= ');';
                        $foreignKeys[] = $str;
                        $this->upStr->addStr($str);
                    }
                }
            }
        }


    }

    /**
     * ---------------------------------------
     * 生成表数据
     * @param $table string 完整表名
     * @return array
     * ---------------------------------------
     */
    public function generateTableData($table){
        $tableSchema = \Yii::$app->db->getTableSchema($table);
        $data = Yii::$app->db->createCommand('SELECT * FROM `' . $table . '`')->queryAll();
        //$array = [];
        if (is_array($data)) {
            $this->upStr->addStr('/* 表数据 */');
            foreach ($data as $row) {
                $out = '$this->insert(\'{{%' . $this->getTableName($table) . '}}\',[';
                foreach ($tableSchema->columns as $column) {
                    /* 注意：addslashes会将null转化为'' */
                    if (is_null($row[ $column->name ])) {
                        $out .= "'" . $column->name . "'=>NULL,";
                    } elseif ($this->is_serialized($row[ $column->name ])) {
                        /* 序列化的内容被addslashes就不能反序列化了 */
                        $out .= "'" . $column->name . "'=>'" . $row[ $column->name ] . "',";
                    } else {
                        $out .= "'" . $column->name . "'=>'" . addslashes($row[ $column->name ]) . "',";
                    }
                }
                $out = rtrim($out, ',') . ']);';
                //$array[] = $out;
                $this->upStr->addStr($out);
            }
        }
        //return $array;
    }

    /**
     * ---------------------------------------
     * 获取表option
     * @param $table string 完整表名
     * @return string
     * ---------------------------------------
     */
    public function getTableOption($table){
        $tableOption = '';
        $table_tructure = Yii::$app->db->createCommand('show create table `' . $table . '`')->queryOne();
        preg_match('/ENGINE=.*/', $table_tructure['Create Table'], $options);
        $tableOption = preg_replace('/AUTO_INCREMENT=\d*/', '', $options[0]);

        return $tableOption?$tableOption:'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }

    /**
     * ---------------------------------------
     * 获取表结构中的一个字段
     * @param $column \yii\db\ColumnSchema
     * @return string
     * ---------------------------------------
     */
    public function getTableField($column){
        $fields = '';
        /* 字段类型 */
        $fields .= "'{$column->name}' => '" . $column->dbType;
        /* 是否为空 */
        if (isset($column->allowNull))
            $fields .= ($column->allowNull) ? ' NULL' : ' NOT NULL';
        /* 自增 */
        if (isset($column->autoIncrement))
            $fields .= ($column->autoIncrement) ? ' AUTO_INCREMENT' : '';
        /* 默认值 */
        if (isset($column->defaultValue))
            if (!is_array($column->defaultValue)) {
                //0 is int
                if(is_int($column->defaultValue) || !empty($column->defaultValue) || $column->defaultValue == '')
                {
                    $fields .= " DEFAULT \'{$column->defaultValue}\'";
                }
            } else {
                $fields .= (empty($column->defaultValue)) ? '' : " DEFAULT " . $column->defaultValue['expression'] . " ";
            }
        /* 描述 */
        if (!empty($column->comment))
            $fields .= " COMMENT \'{$column->comment}\'";
        $fields .= "',";
        return $fields;
    }
    
    /**
     * ---------------------------------------
     * 判断字符串是否被序列化
     * @param $data string  
     * @return bool
     * ---------------------------------------
     */
    protected function is_serialized( $data ) {
        $data = trim( $data );
        if ( 'N;' == $data )
            return true;
        if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
            return false;
        switch ( $badions[1] ) {
            case 'a' :
            case 'O' :
            case 's' :
                if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                    return true;
                break;
        }
        return false;
    }


}
