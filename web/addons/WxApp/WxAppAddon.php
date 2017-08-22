<?php 
namespace addons\WxApp;

class WxAppAddon
{
    /**
     * 参数配置 
     * [true,false] 开启|关闭
     * 使用方法在当前文件下的Setting.php
     * @var bool
     */
    public $setting = false;
    
    /**
     * 钩子
     * [true,false] 开启|关闭
     * 使用方法在当前文件下的Setting.php
     * @var bool
     */
    public $hook = false;
    
     /**
     * 小程序
     * [true,false] 开启|关闭
     * @var bool
     */
    public $wxapp_support = true;
    
    /**
     * 类别
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
    public $type = 'activity';
    
     /**
     * 微信接收消息类别
     * @var array 
     */
    public $wechatMessage = [];
    
    /**
     * 配置信息
     * @var array
     */
    public $info = [
        'name' => 'WxApp',
        'title' => '小程序',
        'description' => '小程序测试',
        'author' => '简言',
        'version' => '1.0'
    ];
    
    /**
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
     * @var array
     */
    public $bindings = [
            'cover' => [
        ],
            'menu' => [
        ]
    ];
    
    /**
     * 保存在当前模块的根目录下面
     * 例如 public $install = 'install.php';
     * 安装SQL,只支持php文件
     * @var string
     */
    public $install = '';
    
    /**
     * 卸载SQL
     * @var string
     */
    public $uninstall = '';
    
    /**
     * 更新SQL
     * @var string
     */
    public $upgrade = '';
}
            