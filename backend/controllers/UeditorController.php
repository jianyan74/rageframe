<?php
namespace backend\controllers;

use Yii;
use crazydb\ueditor\Uploader;

/**
 * 百度编辑器
 *
 * Class UEditorController
 * @package jianyan\basics\backend\controllers
 */
class UeditorController extends \crazydb\ueditor\UEditorController
{
    public $config = [
        // server config @see http://fex-team.github.io/ueditor/#server-config
        'imagePathFormat' => '/upload/image/{yyyy}/{mm}/{dd}/{time}_{rand:6}',
        'scrawlPathFormat' => '/upload/image/{yyyy}/{mm}/{dd}/{time}_{rand:6}',
        'snapscreenPathFormat' => '/upload/image/{yyyy}/{mm}{dd}/{time}_{rand:6}',
        'catcherPathFormat' => '/upload/image/{yyyy}/{mm}/{dd}/{time}_{rand:6}',
        'videoPathFormat' => '/upload/video/{yyyy}/{mm}/{dd}/{time}_{rand:6}',
        'filePathFormat' => '/upload/file/{yyyy}/{mm}/{dd}/{rand:4}_{filename}',
        'imageManagerListPath' => '/upload/image/',
        'fileManagerListPath' => '/upload/file/',
    ];

    public function init()
    {
        parent::init();
        //do something
        //这里可以对扩展的访问权限进行控制
    }

    /**
     * 各种上传
     * @param $fieldName
     * @param $config
     * @param $base64
     * @return array
     */
    protected function upload($fieldName, $config, $base64 = 'upload')
    {
        $up = new Uploader($fieldName, $config, $base64);

        if ($this->allowIntranet)
            $up->setAllowIntranet(true);

        $info = $up->getFileInfo();
        if (($this->thumbnail or $this->zoom or $this->watermark) && $info['state'] == 'SUCCESS' && in_array($info['type'], ['.png', '.jpg', '.bmp', '.gif']))
        {
            $info['thumbnail'] = Yii::getAlias('@attachurl') . $this->imageHandle($info['url']);
        }

        $info['url'] = Yii::getAlias('@attachurl') . $info['url'];
        $info['original'] = htmlspecialchars($info['original']);
        $info['width'] = $info['height'] = 500;
        return $info;
    }

    /**
     * 文件和图片管理action使用
     * @param $allowFiles
     * @param $listSize
     * @param $path
     * @return array
     */
    protected function manage($allowFiles, $listSize, $path)
    {
        $allowFiles = substr(str_replace('.', '|', join('', $allowFiles)), 1);
        /* 获取参数 */
        $size = isset($_GET['size']) ? $_GET['size'] : $listSize;
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        $path = Yii::getAlias('@attachment') . (substr($path, 0, 1) == '/' ? '' : '/') . $path;
        $files = $this->getFiles($path, $allowFiles);
        if (!count($files)) {
            $result = [
                'state' => 'no match file',
                'list' => [],
                'start' => $start,
                'total' => count($files),
            ];
            return $result;
        }
        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
        /* 返回数据 */
        $result = [
            'state' => 'SUCCESS',
            'list' => $list,
            'start' => $start,
            'total' => count($files),
        ];
        return $result;
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param $allowFiles
     * @param array $files
     * @return array|null
     */
    protected function getFiles($path, $allowFiles, &$files = [])
    {
        if (!is_dir($path)) return null;
        if (in_array(basename($path), $this->ignoreDir)) return null;
        if (substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        //baseUrl用于兼容使用alias的二级目录部署方式
        $baseUrl = Yii::getAlias('@attachurl');
        while (false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..')
            {
                $path2 = $path . $file;
                if (is_dir($path2))
                {
                    $this->getFiles($path2, $allowFiles, $files);
                }
                else
                {
                    $pat = "/\.(" . $allowFiles . ")$/i";
                    if ($this->action->id == 'list-image')
                    {
                        // $pat = "/\.thumbnail\.(" . $allowFiles . ")$/i";
                    }

                    if (preg_match($pat, $file))
                    {

                        $files[] = [
                            'url' => $baseUrl . substr($path2, strlen(Yii::getAlias('@attachment'))),
                            'mtime' => filemtime($path2)
                        ];
                    }
                }
            }
        }
        return $files;
    }
}