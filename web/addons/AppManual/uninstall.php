<?php

//表前缀
$table_prefixion = "yl_addon_app_";
//列表
$table_name = ['manual'];

$sql = "";
foreach ($table_name as $value)
{
    $table = $table_prefixion.$value;
    $sql  .= "DROP TABLE IF EXISTS `{$table}`;";
}

//执行sql
Yii::$app->getDb()->createCommand($sql)->execute();