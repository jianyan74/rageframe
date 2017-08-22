<?php 
namespace addons\DebrisGroup;

class DebrisGroupAddon
{
    /**
     * 显示目录在当前文件下的Setting.php
     * @var bool
     * 参数配置
     * [true,false] 开启|关闭
     */
    public $setting = false;
    
    /**
     * 显示目录在当前文件下的Setting.php
     * @var bool
     * 钩子
     * [true,false] 开启|关闭
     */
    public $hook = true;
    
    /**
     * @var string 类别
     * [
     *      'business'  => "主要业务",
     *      'customer'  => "客户关系",
     *      'activity'  => "营销及活动",
     *      'services'  => "常用服务及工具",
     *      'biz'       => "行业解决方案",
     *      'h5game'    => "H5游戏",
     *      'plug'      => "功能插件",  
     *      'other'     => "其他",
     * ]
     */
    public $type = 'plug';
    
    /**
     * 配置信息
     * @var array
     */
    public $info = [
        'name' => 'DebrisGroup',
        'title' => '碎片组别',
        'description' => '碎片组别',
        'author' => '简言',
        'version' => '1.0'
    ];
    
    /**
     * 后台菜单
     * @var array
     * 例如
     *     public $bindings = [
     *          'cover' => [
     *          ]，
     *         'menu' => [
     *             [
     *                  'title' => '碎片列表',
     *                  'route' => 'Debris/index',
     *                  'icon' => 'fa fa-weixin',
     *              ]
     *           ...
     *         ],
     *     ];
     */
    public $bindings = [
            'cover' => [
        ],
            'menu' => [
            [
                'title' => '内容管理',
                'route' => 'index/index',
                'icon' => ''
            ],
            [
                'title' => '分类管理',
                'route' => 'cate/index',
                'icon' => ''
            ],
        ]
    ];
    
    /**
     * 保存在当前模块的根目录下面
     * @var string
     * 例如 public $install = 'install.php';
     * 安装SQL,只支持php文件
     */
    public $install = 'install.php';
    
    /**
     * @var string 卸载SQL
     */
    public $uninstall = 'uninstall.php';
    
    /**
     * @var string 更新SQL
     */
    public $upgrade = 'upgrade.php';
}
            