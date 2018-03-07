<?php 
namespace addons\AppExample;

class AppExampleAddon
{
    /**
     * 参数配置
     *
     * [true,false] 开启|关闭
     * 使用方法在当前文件下的Setting.php
     * @var bool
     */
    public $setting = false;
    
    /**
     * 钩子
     *
     * [true,false] 开启|关闭
     * 使用方法在当前文件下的Setting.php
     * @var bool
     */
    public $hook = true;
    
     /**
     * 小程序
     *
     * [true,false] 开启|关闭
     * @var bool
     */
    public $wxappSupport = false;

    /**
     * 规则管理
     *
     * [true,false] 开启|关闭
     * @var bool
     */
    public $isRule = false;
    
    /**
     * 类别
     *
     * @var string 
     * [
     *      'plug'      => "功能插件",  
     *      'business'  => "主要业务",
     *      'customer'  => "客户关系",
     *      'activity'  => "营销及活动",
     *      'services'  => "常用服务及工具",
     *      'biz'       => "行业解决方案",
     *      'h5game'    => "H5游戏",
     *      'other'     => "其他",
     * ]
     */
    public $type = 'plug';
    
     /**
     * 微信接收消息类别
      *
     * @var array 
     */
    public $wechatMessage = [];
    
    /**
     * 配置信息
     *
     * @var array
     */
    public $info = [
        'name' => 'AppExample',
        'title' => '示例管理',
        'brief_introduction' => '系统的功能示例',
        'description' => '系统自带的功能使用示例及其说明，包含一些简单的交互',
        'author' => '简言',
        'version' => '1.0',
    ];
    
    /**
     * 后台菜单
     *
     * 例如
     * public $bindings = [
     *      'cover' => [
     *      ]，
     *     'menu' => [
     *         [
     *              'title' => '碎片列表',
     *              'route' => 'Debris/index',
     *              'icon' => 'fa fa-weixin',
     *          ]
     *       ...
     *     ],
     * ];
     * @var array
     */
    public $bindings = [
        'cover' => [
        ],
        'menu' => [
            [
                'title' => '基本表格',
                'route' => 'curd-base/index',
                'icon' => ''
            ],
            [
                'title' => 'Grid表格',
                'route' => 'curd-grid/index',
                'icon' => ''
            ],
        ]
    ];
    
    /**
     * 保存在当前模块的根目录下面
     *
     * 例如 public $install = 'install.php';
     * 安装SQL,只支持php文件
     * @var string
     */
    public $install = 'install.php';
    
    /**
     * 卸载SQL
     *
     * @var string
     */
    public $uninstall = 'uninstall.php';
    
    /**
     * 更新SQL
     *
     * @var string
     */
    public $upgrade = 'upgrade.php';
}
            