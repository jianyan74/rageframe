<?php
namespace common\helpers;

use \PHPExcel;
use \PHPExcel_Reader_Excel2007;
use \PHPExcel_Reader_Excel5;
use \PHPExcel_IOFactory;

class ExcelHelper
{
    /**
     * 读取excel表格中的数据
     * @author xxx
     * @dateTime 2017-06-12T09:39:01+0800
     * @param    string $filePath excel文件路径
     * @param    integer $startRow 开始的行数
     * @return   array
     */
    public static function getExcelData($filePath, $startRow = 1)
    {
        $PHPExcel = new PHPExcel();
        /**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
        $PHPReader = new PHPExcel_Reader_Excel2007();
        //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
        $PHPReader->setReadDataOnly(TRUE);
        if (!$PHPReader->canRead($filePath))
        {
            $PHPReader = new PHPExcel_Reader_Excel5();
            //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
            $PHPReader->setReadDataOnly(TRUE);
            if (!$PHPReader->canRead($filePath))
            {
                echo '不能读取excel';
                return;
            }
        }

        $PHPExcel = $PHPReader->load($filePath);
        //获取sheet的数量
        $sheetCount = $PHPExcel->getSheetCount();
        //获取sheet的名称
        $sheetNames = $PHPExcel->getSheetNames();

        //获取所有的sheet表格数据
        $excleDatas = array();
        $emptyRowNum = 0;
        for ($i = 0; $i < $sheetCount; $i++)
        {
            /**读取excel文件中的第一个工作表*/
            $currentSheet = $PHPExcel->getSheet($i);
            /**取得最大的列号*/
            $allColumn = $currentSheet->getHighestColumn();
            /**取得一共有多少行*/
            $allRow = $currentSheet->getHighestRow();

            $arr = array();
            for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++)
            {
                /**从第A列开始输出*/
                for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++)
                {
                    $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue();
                    $arr[$currentRow][] = trim($val);
                }
                $arr[$currentRow] = array_filter($arr[$currentRow]);
                //统计连续空行
                if(empty($arr[$currentRow]) && $emptyRowNum <= 50)
                {
                    $emptyRowNum++ ;
                }
                else
                {
                    $emptyRowNum = 0;
                }
                //防止坑队友的同事在excel里面弄出很多的空行，陷入很漫长的循环中，设置如果连续超过50个空行就退出循环，返回结果
                //连续50行数据为空，不再读取后面行的数据，防止读满内存
                if($emptyRowNum > 50)
                {
                    break;
                }
            }
            $excleDatas[$i] = $arr; //多个sheet的数组的集合
        }

        //这里我只需要用到第一个sheet的数据，所以只返回了第一个sheet的数据
        $returnData = $excleDatas ? array_shift($excleDatas) : [];

        //第一行数据就是空的，为了保留其原始数据，第一行数据就不做array_fiter操作；
        $returnData = $returnData && isset($returnData[$startRow]) && !empty($returnData[$startRow])  ? array_filter($returnData) : $returnData;
        return $returnData;
        //return $excleDatas  ? array_filter(array_shift($excleDatas)) : [];
    }

    /**
     * 生成excel数据表
     * e.g.
     * $fields = [
     *     ['key' => 'province', 'name' => '省', 'required' => false]
     *     ['key' => 'city', 'name' => '市', 'required' => true]
     *     ['key' => 'district', 'name' => '区/县', 'required' => true]
     *     ['key' => 'street', 'name' => '街道', 'required' => true]
     * ];
     *
     * $dataList = [
     *     ['province' => 'xx省' , 'city'=>'xx市' , 'district' => 'xx县' ,'street' => 'xx街道'],
     *     ['province' => 'xx省' , 'city'=>'xx市' , 'district' => 'xx县' ,'street' => 'xx街道'],
     *     ['province' => 'xx省' , 'city'=>'xx市' , 'district' => 'xx县' ,'street' => 'xx街道'],
     *     ['province' => 'xx省' , 'city'=>'xx市' , 'district' => 'xx县' ,'street' => 'xx街道'],
     * ]
     *
     * @author xxx
     * @dateTime 2017-07-18T15:19:04+0800
     * @param    array $fileds 表头数据
     * @param    array $dataList 导出数据的数组
     * @param    string $fileName 生成的文件名
     * @return   mix
     */
    public static function createExcelFromData($fileds, $dataList = [], $fileName = 'data.xls')
    {
        if(!count($fileds || !count($dataList)))
        {
            return false;
        }

        $dataList = array_values($dataList);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $i = 0;
        foreach ($fileds as $key => $value)
        {
            $cloumStr = chr(ord("A") + $key);
            $column = $cloumStr . "1";
            //必填字段列表标红
            $required = isset($value['required']) ? $value['required'] : false;
            if ($required == true)
            {
                //把必填字段标红
                $objPHPExcel->getActiveSheet()->getStyle($column)->getFont()->getColor()->setARGB('FF0000');
            }
            $objPHPExcel->getActiveSheet()->setCellValue($column, $value['name']);
            $i++;
        }

        $filedKeys = array_column($fileds, 'key');
        $list = [];
        ob_start();
        foreach ($dataList as $key => $value)
        {
            if ($key % 5000 == 0)
            {
                ob_flush();
                flush();
            }

            $num = $key + 2;
            for ($j = 0; $j < $i; $j++)
            {
                $cloumStr = chr(ord("A") + $j);
                $column = $cloumStr . $num;
                if(isset($value[$filedKeys[$j]]))
                {
                    $objPHPExcel->getActiveSheet()->setCellValue($column, $value[$filedKeys[$j]]);
                }
                else
                {
                    $objPHPExcel->getActiveSheet()->setCellValue($column, '');
                }
            }
        }

        //设置必填字段字体颜色
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if(php_sapi_name() != 'cli')
        {
            $fileName = basename($fileName);
            $fileName = iconv("utf-8", "gb2312", $fileName);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$fileName);
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output'); //文件通过浏览器下载
        }
        else
        {
            $dirname = dirname($fileName);
            if ($dirname != '.')
            {
                //文件路径如果不存在则递归创健
                FileHelper::mkdirs($dirname);
            }
            $objWriter->save($fileName); //脚本方式运行，保存在指定目录
            if(!file_exists($fileName))
            {
                return false;
            }

            return true;
        }

        return true;
    }
}