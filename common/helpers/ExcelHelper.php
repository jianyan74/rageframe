<?php
namespace common\helpers;

use \PHPExcel;
use \PHPExcel_Reader_Excel2007;
use \PHPExcel_Reader_Excel5;
use \PHPExcel_IOFactory;

/**
 * 表格导出辅助类
 * Class ExcelHelper
 * @package common\helpers
 */
class ExcelHelper
{
    /**
     * 读取excel表格中的数据
     *
     * @param string $filePath excel文件路径
     * @param int $startRow 开始的行数
     * @return array|bool|mixed
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public static function getExcelData($filePath, $startRow = 1)
    {
        $PHPExcel = new PHPExcel();
        /**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
        $PHPReader = new PHPExcel_Reader_Excel2007();
        // setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
        $PHPReader->setReadDataOnly(TRUE);
        if (!$PHPReader->canRead($filePath))
        {
            $PHPReader = new PHPExcel_Reader_Excel5();
            // setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
            $PHPReader->setReadDataOnly(TRUE);
            if (!$PHPReader->canRead($filePath))
            {
                echo '不能读取excel';
                return false;
            }
        }

        $PHPExcel = $PHPReader->load($filePath);
        // 获取sheet的数量
        $sheetCount = $PHPExcel->getSheetCount();
        // 获取sheet的名称
        $sheetNames = $PHPExcel->getSheetNames();

        // 获取所有的sheet表格数据
        $excleDatas = [];
        $emptyRowNum = 0;
        for ($i = 0; $i < $sheetCount; $i++)
        {
            /**读取excel文件中的第一个工作表*/
            $currentSheet = $PHPExcel->getSheet($i);
            /**取得最大的列号*/
            $allColumn = $currentSheet->getHighestColumn();
            /**取得一共有多少行*/
            $allRow = $currentSheet->getHighestRow();

            $arr = [];
            for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++)
            {
                /**从第A列开始输出*/
                for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++)
                {
                    $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 64, $currentRow)->getValue();
                    $arr[$currentRow][] = trim($val);
                }
                $arr[$currentRow] = array_filter($arr[$currentRow]);
                // 统计连续空行
                if(empty($arr[$currentRow]) && $emptyRowNum <= 50)
                {
                    $emptyRowNum++ ;
                }
                else
                {
                    $emptyRowNum = 0;
                }
                // 防止坑队友的同事在excel里面弄出很多的空行，陷入很漫长的循环中，设置如果连续超过50个空行就退出循环，返回结果
                // 连续50行数据为空，不再读取后面行的数据，防止读满内存
                if($emptyRowNum > 50)
                {
                    break;
                }
            }
            $excleDatas[$i] = $arr; // 多个sheet的数组的集合
        }

        // 这里我只需要用到第一个sheet的数据，所以只返回了第一个sheet的数据
        $returnData = $excleDatas ? array_shift($excleDatas) : [];

        // 第一行数据就是空的，为了保留其原始数据，第一行数据就不做array_fiter操作；
        $returnData = $returnData && isset($returnData[$startRow]) && !empty($returnData[$startRow])  ? array_filter($returnData) : $returnData;
        return $returnData;
        // return $excleDatas  ? array_filter(array_shift($excleDatas)) : [];
    }

    /**
     * 导出Excel
     *
     * @param array $list
     * @param array $header
     *  $header = [
     *        ['field' => 'a', 'name' =>  '文本', 'type' => 'text'],
     *        ['field' => 'a.child.num', 'name' =>  '文本', 'type' => 'text'],// 表示读取数组['a']['child']['num']
     *        ['field' => 'b', 'name' =>  '创建日期', 'type' => 'date', 'rule' => 'Y-m-d H:i:s'],
     *        ['field' => 'c', 'name' =>  '选择内容', 'type' => 'selectd', 'rule' => ['1' => '选择一','2' => '选择二']],
     * ];
     * @param string $filename
     * @param string $title
     * @return bool
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public static function exportExcelData ($list = [], $header = [], $filename = '', $title = 'simple')
    {
        if (!is_array ($list) || !is_array ($header)) return false;
        // 默认文件名称
        !$filename && $filename = time();
        $objPHPExcel = new \PHPExcel();
        // 设置属性
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
        $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        // 添加一些数据
        $objPHPExcel->setActiveSheetIndex(0);
        // 写入头部
        $hk = 0;
        foreach ($header as $k => $v)
        {
            $colum = \PHPExcel_Cell::stringFromColumnIndex($hk);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v['name']);
            $hk += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        $size = ceil(count($list) / 500);
        for($i = 0; $i < $size; $i++)
        {
            $buffer = array_slice($list, $i * 500, 500);
            foreach($buffer as $row)
            {
                $span = 0;
                foreach($header as $key => $value)
                {
                    $resultData = trim(self::formattingField($row, $value['field']));
                    $realData = self::formatting($header[$key], $resultData);
                    $j = \PHPExcel_Cell::stringFromColumnIndex($span);
                    $objActSheet->setCellValue($j . $column, $realData);
                    $span++;
                }

                $column++;
            }
        }

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle($title);
        // Save Excel 2007 file
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Pragma:public');
        header("Content-Type:application/x-msexecl;name=\"{$filename}.xls\"");
        header("Content-Disposition:inline;filename=\"{$filename}.xls\"");
        $objWriter->save('php://output');
        exit();
    }

    /**
     * 导出csv
     *
     * @param array $list
     * @param array $header
     *  $header = [
     *        ['field' => 'a', 'name' =>  '文本', 'type' => 'text'],
     *        ['field' => 'a.child.num', 'name' =>  '文本', 'type' => 'text'],// 表示读取数组['a']['child']['num']
     *        ['field' => 'b', 'name' =>  '创建日期', 'type' => 'date', 'rule' => 'Y-m-d H:i:s'],
     *        ['field' => 'c', 'name' =>  '选择内容', 'type' => 'selectd', 'rule' => ['1' => '选择一','2' => '选择二']],
     * ];
     * @param string $title
     * @param string $filename
     * @return bool
     */
    public static function exportCSVData($list = [], $header = [], $filename = '')
    {
        if (!is_array ($list) || !is_array ($header)) return false;
        // 默认文件名称
        !$filename && $filename = time();

        $html = "\xEF\xBB\xBF";
        foreach($header as $li)
        {
            $html .= $li['name'] . "\t ,";
        }

        $html .= "\n";

        if(!empty($list))
        {
            $info = [];
            $size = ceil(count($list) / 500);
            for($i = 0; $i < $size; $i++)
            {
                $buffer = array_slice($list, $i * 500, 500);
                foreach($buffer as $row)
                {
                    $data = [];
                    foreach($header as $key => $value)
                    {
                        $resultData = trim(self::formattingField($row, $value['field']));
                        $realData = self::formatting($header[$key], $resultData);
                        $data[] = str_replace(PHP_EOL,'', $realData);
                    }

                    $info[] = implode("\t ,", $data) . "\t ,";
                    unset($data);
                }
            }

            $html .= implode("\n", $info);
        }

        header("Content-type:text/csv");
        header("Content-Disposition:attachment; filename={$filename}.csv");
        echo $html;
        exit();
    }

    /**
     * 格式化内容
     *
     * @param array $array 头部规则
     * @return false|mixed|null|string 内容值
     */
    protected static function formatting(array $array, $value)
    {
        switch ($array['type'])
        {
            // 文本
            case 'text' :
                return $value;
                break;

            // 日期
            case  'date' :
                return date($array['rule'], $value);
                break;

            // 选择框
            case  'selectd' :
                return  isset($array['rule'][$value])  ? $array['rule'][$value] : null ;
                break;
        }

        return null;
    }

    /**
     * 解析字段
     *
     * @param $row
     * @param $field
     * @return mixed
     */
    protected static function formattingField($row, $field)
    {
        $newField = explode('.', $field);
        if(count($newField) == 1)
        {
            return $row[$field];
        }

        foreach ($newField as $item)
        {
            if(isset($row[$item]))
            {
                $row = $row[$item];
            }
            else
            {
                break;
            }
        }

        return $row;
    }
}