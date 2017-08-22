<?php 
namespace addons\FriendLink;

class FriendLinkAddon
{
/**
     * @var bool
     * 参数配置
     * [true,false] 开启|关闭
     * 显示目录在当前文件下的Setting.php
     */
    public $setting = false;
    /**
     * @var bool
     * 钩子
     * [true,false] 开启|关闭
     * 显示目录在当前文件下的Setting.php
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
     * @var array
     * 配置信息
     */
    public $info = [
        'name' => 'FriendLink',
        'title' => '友情链接',
        'description' => '友情链接',
        'author' => '简言',
        'version' => '1.0'
    ];
    /**
     * @var array
     * 后台菜单
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
                'title' => '链接管理',
                'route' => 'friend-link/index',
                'icon' => ''
            ],
        ]
    ];
    /**
     * @var string
     * 保存在当前模块的根目录下面
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
    public $upgrade = '';
}
            