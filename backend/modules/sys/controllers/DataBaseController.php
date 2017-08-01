<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\web\Response;
use common\models\sys\Database;
use backend\controllers\MController;

/**
 * 数据库备份还原控制器
 * Class DataBaseController
 * @package backend\modules\sys\controllers
 */
class DataBaseController extends MController
{
    protected $path;
    protected $config;

    public function init()
    {
        $path   = Yii::$app->params['dataBackupPath'];
        //读取备份配置
        $config = [
            'path'     => realpath($path) . DIRECTORY_SEPARATOR,
            'part'     => Yii::$app->params['dataBackPartSize'],
            'compress' => Yii::$app->params['dataBackCompress'],
            'level'    => Yii::$app->params['dataBackCompressLevel'],
            'lock'     => Yii::$app->params['dataBackLock'],
        ];
        $this->path     = $path;
        $this->config   = $config;

        //判断目测是否存在，不存在则创建
        if(!is_dir($path))
        {
            mkdir($path, 0755, true);
        }
    }

    /**
     * 备份列表
     */
    public function actionBackups()
    {
        $Db      = \Yii::$app->db;
        $models  = $Db->createCommand('SHOW TABLE STATUS')->queryAll();
        $models  = array_map('array_change_key_case', $models);

        return $this->render('backups', [
            'models' => $models
        ]);

    }

    /**
     * 备份检测
     * @return array
     */
    public function actionExport()
    {
        $result = [];
        $result['flg'] = 2;
        $result['msg'] = "";

        Yii::$app->response->format = Response::FORMAT_JSON;
        $tables = Yii::$app->request->post('tables');
        if(empty($tables))
        {
            $result['msg'] = "请选择要备份的表！";
            return $result;
        }

        //读取备份配置
        $config = $this->config;

        //检查是否有正在执行的任务
        $lock = "{$config['path']}".$config['lock'];

        if(is_file($lock))
        {
            $result['msg'] = "检测到有一个备份任务正在执行，请稍后或清理缓存后再试！";
            return $result;
        }
        else
        {
            //创建锁文件
            file_put_contents($lock, time());
        }

        //检查备份目录是否可写
        if (!is_writeable($config['path']))
        {
            $result['msg'] = "备份目录不存在或不可写，请检查后重试！";
            return $result;
        }

        //生成备份文件信息
        $file = [
            'name' => date('Ymd-His', time()),
            'part' => 1,
        ];

        //创建备份文件
        $Database = new Database($file, $config);
        if(false !== $Database->create())
        {
            //缓存配置信息
            Yii::$app->session->set('backup_config', $config);
            //缓存文件信息
            Yii::$app->session->set('backup_file', $file);
            //缓存要备份的表
            Yii::$app->session->set('backup_tables', $tables);

            $tab = ['id' => 0, 'start' => 0];
            return [
                'flg'       => 1,
                'msg'       => '初始化成功！',
                'tables'    => $tables,
                'tab'       => $tab
            ];
        }
        else
        {
            $result['msg'] = "初始化失败，备份文件创建失败！";
            return $result;
        }
    }

    /**
     * 开始备份
     * @return array
     */
    public function actionExportStart()
    {
        $result = [];
        $result['flg'] = 2;
        $result['msg'] = "";
        Yii::$app->response->format = Response::FORMAT_JSON;

        $tables = Yii::$app->session->get('backup_tables');
        $file   = Yii::$app->session->get('backup_file');
        $config = Yii::$app->session->get('backup_config');

        $id     = Yii::$app->request->post('id');
        $start  = Yii::$app->request->post('start');

        //备份指定表
        $Database = new Database($file,$config);
        $start    = $Database->backup($tables[$id], $start);
        if($start === false)
        {
            $result['msg'] = "备份出错";
            return $result;
        }
        elseif ($start === 0)
        {
            //下一表
            if(isset($tables[++$id]))
            {
                $tab = array('id' => $id, 'start' => 0);
                $result['flg'] = 1;
                $result['msg'] = "备份完成";//对下一个表进行备份
                $result['tablename'] = $tables[--$id];
                $result['tab'] = $tab;
                $result['achieveStatus'] = 0;
                return $result;
            }
            else
            {
                //备份完成，清空缓存
                unlink($config['path'] . $config['lock']);
                Yii::$app->session->set('backup_tables', null);
                Yii::$app->session->set('backup_file', null);
                Yii::$app->session->set('backup_config', null);

                $result['flg'] = 1;
                $result['msg'] = "备份完成";
                $result['tablename'] = $tables[--$id];
                $result['achieveStatus'] = 1;
                return $result;
            }
        }
        else
        {
            $tab  = array('id' => $id, 'start' => $start[0]);
            $rate = floor(100 * ($start[0] / $start[1]));

            $result['flg'] = 1;
            $result['msg'] = "正在备份...({$rate}%)";
            $result['tablename'] = $tables[$id];
            $result['tab'] = $tab;
            $result['achieveStatus'] = 0;

            return $result;
        }


    }

    /**
     * 优化表
     * @param  String $tables 表名
     */
    public function actionOptimize()
    {
        $result = [];
        $result['flg'] = 2;
        $result['msg'] = "";

        $tables  = Yii::$app->request->post('tables','');
        if($tables)
        {
            $Db      = \Yii::$app->db;
            //判断是否是数组
            if(is_array($tables))
            {
                $tables = implode('`,`', $tables);
                $list = $Db->createCommand("OPTIMIZE TABLE `{$tables}`")->queryAll();

                if($list)
                {
                    $result['flg'] = 1;
                    $result['msg'] = "数据表优化完成！";
                }
                else
                {
                    $result['msg'] = "数据表优化出错请重试！";
                }
            }
            else
            {
                $list = $Db->createCommand("REPAIR TABLE `{$tables}`")->queryOne();
                //判断是否成功
                if($list['Msg_text'] == "OK")
                {
                    $result['flg'] = 1;
                    $result['msg'] = "数据表'{$tables}'优化完成！";
                }
                else
                {
                    $result['msg'] = "数据表'{$tables}'优化出错！错误信息:". $list['Msg_text'];
                }
            }
        }
        else
        {
            $result['msg'] = "请指定要优化的表";
        }

        echo json_encode($result);
    }

    /**
     * 修复表
     * @param  String $tables 表名
     */
    public function actionRepair()
    {
        $result = [];
        $result['flg'] = 2;
        $result['msg'] = "";
        $tables  = Yii::$app->request->post('tables','');

        if($tables)
        {
            $Db      = \Yii::$app->db;
            //判断是否是数组
            if(is_array($tables))
            {
                $tables = implode('`,`', $tables);
                $list = $Db->createCommand("REPAIR TABLE `{$tables}`")->queryAll();

                if($list)
                {
                    $result['flg'] = 1;
                    $result['msg'] = "数据表修复完成！";
                }
                else
                {
                    $result['msg'] = "数据表修复出错！";
                }
            }
            else
            {
                $list = $Db->createCommand("REPAIR TABLE `{$tables}`")->queryOne();

                if($list['Msg_text'] == "OK")
                {
                    $result['flg'] = 1;
                    $result['msg'] = "数据表'{$tables}'修复完成！";
                }
                else
                {
                    $result['msg'] = "数据表'{$tables}'修复出错！错误信息:". $list['Msg_text'];
                }
            }
        }
        else
        {
            $result['msg'] = "请指定要修复的表";
        }

        echo json_encode($result);
    }

    /********************************************************************************/
    /************************************还原数据库************************************/
    /********************************************************************************/

    /**
     * 还原列表
     */
    public function actionRestore()
    {
        Yii::$app->language = "";

        //文件夹路径
        $path    = $this->path;
        $flag    = \FilesystemIterator::KEY_AS_FILENAME;
        $glob    = new \FilesystemIterator($path,  $flag);

        $list = [];
        foreach ($glob as $name => $file)
        {
            //正则匹配文件名
            if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name))
            {
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if(isset($list["{$date} {$time}"]))
                {
                    $info = $list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + $file->getSize();
                }
                else
                {
                    $info['part'] = $part;
                    $info['size'] = $file->getSize();
                }

                $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time']     = strtotime("{$date} {$time}");
                $info['filename'] = $file->getBasename();
                $list["{$date} {$time}"] = $info;
            }
        }

        krsort($list);

        return $this->render('restore', [
            'list' => $list
        ]);
    }

    /**
     * 初始化还原
     */
    public function actionRestoreInit()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = [];
        $result['flg'] = 2;
        $result['msg'] = "";

        $time = Yii::$app->request->post('time');

        $config = $this->config;
        //获取备份文件信息
        $name  = date('Ymd-His', $time) . '-*.sql*';
        $path  = realpath($config['path']) . DIRECTORY_SEPARATOR . $name;
        $files = glob($path);

        $list = [];
        $size = 0;
        foreach($files as $name => $file)
        {
            $size     += filesize($file);
            $basename = basename($file);
            $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
            $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
            $list[$match[6]] = array($match[6], $file, $gz);
        }
        //排序数组
        ksort($list);

        //检测文件正确性
        $last = end($list);
        if(count($list) === $last[0])
        {
            Yii::$app->session->set('backup_list', $list); //缓存备份列表

            $result['flg']   = 1;
            $result['msg']   = "初始化完成";
            $result['part']  = 1;
            $result['start'] = 0;
            return $result;
        }
        else
        {
            $result['flg']   = 2;
            $result['msg']   = "备份文件可能已经损坏，请检查！";
            return $result;
        }
    }

    /**
     * 开始还原到数据库
     */
    public function actionRestoreStart()
    {
        set_time_limit(0);
        Yii::$app->response->format = Response::FORMAT_JSON;

        $config = $this->config;

        $result = [];
        $result['flg'] = 2;
        $result['msg'] = "";
        $part  = Yii::$app->request->post('part');
        $start = Yii::$app->request->post('start');

        $list  = \Yii::$app->session->get('backup_list');
        $arr   = [
            'path'     => realpath($config['path']).DIRECTORY_SEPARATOR,
            'compress' => $list[$part][2]
        ];
        $db    = new Database($list[$part],$arr);
        $start = $db->import($start);

        if (false === $start)
        {
            $result['flg']   = 2;
            $result['msg']   = "还原数据出错";
            return $result;
        }
        elseif(0 === $start)
        {
            //下一卷
            if(isset($list[++$part]))
            {
                $result['flg']   = 1;
                $result['msg']   = "正在还原...#{$part}";
                $result['part']  = $part;
                $result['start1'] = $start;
                $result['start'] = 0;
                $result['achieveStatus'] = 0;
                return $result;
            }
            else
            {
                Yii::$app->session->set('backup_list', null);
                $result['flg']   = 1;
                $result['msg']   = "还原完成";
                $result['achieveStatus'] = 1;
                return $result;
            }
        }
        else
        {
            if($start[1])
            {
                $rate = floor(100 * ($start[0] / $start[1]));
                $result['flg']   = 1;
                $result['msg']   = "正在还原...#{$part} ({$rate}%)";
                $result['part']  = $part;
                $result['start'] = $start[0];
                $result['achieveStatus'] = 0;
                return $result;
            }
            else
            {
                $result['flg']   = 1;
                $result['msg']   = "正在还原...#{$part}";
                $result['part']  = $part;
                $result['start'] = $start[0];
                $result['start1'] = $start;
                $result['gz']    = 1;
                $result['achieveStatus'] = 0;
                return $result;
            }
        }
    }

    /**
     * 删除文件
     */
    public function actionDelete()
    {
        $config = $this->config;
        $time   = Yii::$app->request->get('time');


        if($time)
        {
            $name  = date('Ymd-His', $time) . '-*.sql*';
            $path  = realpath($config['path']) . DIRECTORY_SEPARATOR . $name;
            array_map("unlink", glob($path));
            if(count(glob($path)))
            {
                $this->message('文件删除失败，请检查权限!',$this->redirect(['restore']),'error');
            }
            else
            {
                $this->message('文件删除成功',$this->redirect(['restore']));
            }
        }
        else
        {
            $this->message('文件删除失败',$this->redirect(['restore']),'error');
            return false;
        }
    }


}