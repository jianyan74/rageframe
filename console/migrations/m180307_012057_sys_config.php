<?php

use yii\db\Migration;

class m180307_012057_sys_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_config}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'主键\'',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'配置标题\'',
            'type' => 'varchar(30) NOT NULL DEFAULT \'\' COMMENT \'配置类型\'',
            'name' => 'varchar(30) NOT NULL DEFAULT \'\' COMMENT \'配置标识\'',
            'cate' => 'int(5) unsigned NOT NULL DEFAULT \'0\' COMMENT \'配置分类\'',
            'cate_child' => 'int(5) NULL DEFAULT \'0\' COMMENT \'具体分类\'',
            'extra' => 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'配置值\'',
            'remark' => 'varchar(1000) NOT NULL DEFAULT \'\' COMMENT \'配置说明\'',
            'value' => 'text NULL COMMENT \'配置值\'',
            'is_hide_remark' => 'tinyint(4) NULL DEFAULT \'1\' COMMENT \'是否隐藏说明\'',
            'sort' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'排序\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'append' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated' => 'int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统_公用配置表'");
        
        /* 索引设置 */
        $this->createIndex('uk_name','{{%sys_config}}','name',1);
        $this->createIndex('type','{{%sys_config}}','type',0);
        $this->createIndex('group','{{%sys_config}}','cate',0);
        
        
        /* 表数据 */
        $this->insert('{{%sys_config}}',['id'=>'1','title'=>'网站标题','type'=>'text','name'=>'WEB_SITE_TITLE','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'网站标题前台显示标题','value'=>'RageFrame应用开发引擎','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1378898976','updated'=>'1513853659']);
        $this->insert('{{%sys_config}}',['id'=>'2','title'=>'SEO网站描述','type'=>'textarea','name'=>'WEB_SITE_DESCRIPTION','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'网站搜索引擎描述','value'=>'','is_hide_remark'=>'0','sort'=>'4','status'=>'1','append'=>'1378898976','updated'=>'1513853649']);
        $this->insert('{{%sys_config}}',['id'=>'3','title'=>'SEO网站关键字','type'=>'textarea','name'=>'WEB_SITE_KEYWORD','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'网站搜索引擎关键字,多个关键字以,号分割开 如: A,B.C','value'=>'','is_hide_remark'=>'0','sort'=>'5','status'=>'1','append'=>'1378898976','updated'=>'1513853650']);
        $this->insert('{{%sys_config}}',['id'=>'4','title'=>'关闭站点','type'=>'dropDownList','name'=>'SYS_SITE_CLOSE','cate'=>'2','cate_child'=>'18','extra'=>'0:关闭
1:开启','remark'=>'站点关闭全部用户不能访问','value'=>'1','is_hide_remark'=>'0','sort'=>'4','status'=>'1','append'=>'1378898976','updated'=>'1501730648']);
        $this->insert('{{%sys_config}}',['id'=>'5','title'=>'网站备案号','type'=>'text','name'=>'WEB_SITE_ICP','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'设置在网站底部显示的备案号，如“沪ICP备12007941号-2','value'=>'浙ICP备17025911号-2','is_hide_remark'=>'0','sort'=>'7','status'=>'1','append'=>'1378900335','updated'=>'1513853656']);
        $this->insert('{{%sys_config}}',['id'=>'7','title'=>'后台允许访问IP','type'=>'textarea','name'=>'SYS_ALLOW_IP','cate'=>'2','cate_child'=>'18','extra'=>'','remark'=>'多个用逗号分隔，如果不配置表示不限制IP访问','value'=>'','is_hide_remark'=>'0','sort'=>'5','status'=>'1','append'=>'1387165454','updated'=>'1501730650']);
        $this->insert('{{%sys_config}}',['id'=>'8','title'=>'网站版权所有','type'=>'text','name'=>'WEB_COPYRIGHT_ALL','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'设置在网站底部显示的版权所有','value'=>'© 2016 - 2018 RageFrame All Rights Reserved.','is_hide_remark'=>'0','sort'=>'6','status'=>'1','append'=>'1481591179','updated'=>'1515031869']);
        $this->insert('{{%sys_config}}',['id'=>'125','title'=>'支付证书公钥','type'=>'text','name'=>'ALIPAY_PUBLIC_KEY','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'请填写证书绝对路径','value'=>'','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1515124172','updated'=>'1515124305']);
        $this->insert('{{%sys_config}}',['id'=>'43','title'=>'收款账号','type'=>'text','name'=>'ALIPAY_ACCOUNT','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'如果开启兑换或交易功能，请填写真实有效的支付宝账号。如账号无效或安全码有误，将导致用户支付后无法正确进行正常的交易。 如您没有支付宝帐号，<a href=\"https://memberprod.alipay.com/account/reg/enterpriseIndex.htm\" target=\"_blank\">请点击这里注册</a>','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1481591179','updated'=>'1497182130']);
        $this->insert('{{%sys_config}}',['id'=>'44','title'=>'合作者身份','type'=>'text','name'=>'ALIPAY_COOPERATOR','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'支付宝签约用户请在此处填写支付宝分配给您的合作者身份，签约用户的手续费按照您与支付宝官方的签约协议为准。如果您还未签约，<a href=\"https://memberprod.alipay.com/account/reg/enterpriseIndex.htm\" target=\"_blank\">请点击这里签约</a>；如果已签约,<a href=\"https://b.alipay.com/order/pidKey.htm?pid=2088501719138773&product=fastpay\" target=\"_blank\">请点击这里获取PID、Key</a>;如果在签约时出现合同模板冲突，请咨询0571-88158090','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1481591261','updated'=>'1506756038']);
        $this->insert('{{%sys_config}}',['id'=>'45','title'=>'校验密钥','type'=>'text','name'=>'ALIPAY_KEY','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'填写支付宝分配给您的交易安全校验码，此校验码您可以到支付宝官方的商家服务功能处查看','value'=>'','is_hide_remark'=>'1','sort'=>'1','status'=>'1','append'=>'1481591441','updated'=>'1506756039']);
        $this->insert('{{%sys_config}}',['id'=>'50','title'=>'公众号帐号','type'=>'text','name'=>'WECHAT_ACCOUTN','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'填写公众号的帐号，一般为英文帐号','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1481597325','updated'=>'1497231224']);
        $this->insert('{{%sys_config}}',['id'=>'53','title'=>'AppId','type'=>'text','name'=>'WECHAT_APPID','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'请填写微信公众平台后台的AppId','value'=>'','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1481597992','updated'=>'1518162167']);
        $this->insert('{{%sys_config}}',['id'=>'57','title'=>'原始ID','type'=>'text','name'=>'WECHAT_ID','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'在给粉丝发送客服消息时,原始ID不能为空。建议您完善该选项','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1481598297','updated'=>'1505992643']);
        $this->insert('{{%sys_config}}',['id'=>'52','title'=>'级别','type'=>'radioList','name'=>'WECHAT_RANK','cate'=>'3','cate_child'=>'19','extra'=>'1:普通订阅号,2:普通服务号,3:认证订阅号,4:认证服务号/认证媒体/政府订阅号','remark'=>'注意：即使公众平台显示为“未认证”, 但只要【公众号设置】/【账号详情】下【认证情况】显示资质审核通过, 即可认定为认证号.','value'=>'4','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1481597865','updated'=>'1509584894']);
        $this->insert('{{%sys_config}}',['id'=>'54','title'=>'AppSecret','type'=>'text','name'=>'WECHAT_APPSERCRET','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'请填写微信公众平台后台的AppSecret, 只有填写这两项才能管理自定义菜单','value'=>'','is_hide_remark'=>'0','sort'=>'4','status'=>'1','append'=>'1481598058','updated'=>'1518162167']);
        $this->insert('{{%sys_config}}',['id'=>'55','title'=>'Token','type'=>'secretKeyText','name'=>'WECHAT_TOKEN','cate'=>'3','cate_child'=>'19','extra'=>'32','remark'=>'与公众平台接入设置值一致，必须为英文或者数字，长度为3到32个字符. 请妥善保管, Token 泄露将可能被窃取或篡改平台的操作数据.','value'=>'','is_hide_remark'=>'0','sort'=>'5','status'=>'1','append'=>'1481598165','updated'=>'1515390373']);
        $this->insert('{{%sys_config}}',['id'=>'56','title'=>'EncodingAESKey','type'=>'secretKeyText','name'=>'WECHAT_ENCODINGAESKEY','cate'=>'3','cate_child'=>'19','extra'=>'43','remark'=>'与公众平台接入设置值一致，必须为英文或者数字，长度为43个字符. 请妥善保管, EncodingAESKey 泄露将可能被窃取或篡改平台的操作数据.
','value'=>'','is_hide_remark'=>'0','sort'=>'6','status'=>'1','append'=>'1481598229','updated'=>'1518162167']);
        $this->insert('{{%sys_config}}',['id'=>'61','title'=>'支付商户号','type'=>'text','name'=>'WECHAT_MCHID','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'公众号支付的商户账号','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1484010596','updated'=>'1515391908']);
        $this->insert('{{%sys_config}}',['id'=>'122','title'=>'支付证书公钥','type'=>'text','name'=>'UNION_PUBLIC_KEY','cate'=>'4','cate_child'=>'10','extra'=>'','remark'=>'请填写证书绝对路径','value'=>'','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1515124172','updated'=>'1515390393']);
        $this->insert('{{%sys_config}}',['id'=>'123','title'=>'支付证书私钥','type'=>'text','name'=>'UNION_PRIVATE_KEY','cate'=>'4','cate_child'=>'10','extra'=>'','remark'=>'请填写证书绝对路径','value'=>'','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1515124200','updated'=>'1515124277']);
        $this->insert('{{%sys_config}}',['id'=>'62','title'=>'支付密钥','type'=>'secretKeyText','name'=>'WECHAT_API_KEY','cate'=>'4','cate_child'=>'9','extra'=>'32','remark'=>'此值需要手动在腾讯商户后台API密钥保持一致。','value'=>'','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1484010645','updated'=>'1515460896']);
        $this->insert('{{%sys_config}}',['id'=>'63','title'=>'支付证书公钥','type'=>'text','name'=>'WECHAT_APICLIENT_CERT','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'请填写证书绝对路径','value'=>'','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1484012102','updated'=>'1515130450']);
        $this->insert('{{%sys_config}}',['id'=>'64','title'=>'支付证书私钥','type'=>'text','name'=>'WECHAT_APICLIENT_KEY','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'请填写证书绝对路径','value'=>'','is_hide_remark'=>'0','sort'=>'4','status'=>'1','append'=>'1484012169','updated'=>'1515130602']);
        $this->insert('{{%sys_config}}',['id'=>'69','title'=>'网站logo','type'=>'image','name'=>'WEB_SITE_LOGO','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'商标','value'=>'','is_hide_remark'=>'1','sort'=>'1','status'=>'1','append'=>'1486629289','updated'=>'1513853646']);
        $this->insert('{{%sys_config}}',['id'=>'70','title'=>'菜单级别','type'=>'dropDownList','name'=>'SYS_MAX_LEVEL','cate'=>'2','cate_child'=>'18','extra'=>'1:1级;
2:2级;
3:3级;','remark'=>'无限极分类中最多分级数量,如后台菜单，前台导航等,默认为2级','value'=>'2','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1486630868','updated'=>'1497231298']);
        $this->insert('{{%sys_config}}',['id'=>'71','title'=>'后台分页','type'=>'dropDownList','name'=>'SYS_PAGE','cate'=>'2','cate_child'=>'18','extra'=>'10:10;
20:20;
30:30;
','remark'=>'每页显示记录的数量','value'=>'10','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1486631131','updated'=>'1497239638']);
        $this->insert('{{%sys_config}}',['id'=>'72','title'=>'网站访问量统计','type'=>'textarea','name'=>'WEB_VISIT_CODE','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'用于统计网站访问量的第三方代码','value'=>'','is_hide_remark'=>'0','sort'=>'8','status'=>'1','append'=>'1486952122','updated'=>'1513853653']);
        $this->insert('{{%sys_config}}',['id'=>'96','title'=>'二维码','type'=>'image','name'=>'WECHAT_QR_CODE','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'微信关注二维码','value'=>NULL,'is_hide_remark'=>'0','sort'=>'7','status'=>'1','append'=>'1495421613','updated'=>'1497231279']);
        $this->insert('{{%sys_config}}',['id'=>'82','title'=>'空间名','type'=>'text','name'=>'STORAGE_QINIU_BUCKET','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'七牛的后台管理页面自己创建的空间名','value'=>'','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1491962770','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'79','title'=>'七牛SK','type'=>'password','name'=>'STORAGE_QINIU_SECRECTKEY','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'签名密钥','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1491962373','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'80','title'=>'七牛AK','type'=>'text','name'=>'STORAGE_QINIU_ACCESSKEY','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'用户凭证','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1491962658','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'83','title'=>'域名','type'=>'text','name'=>'STORAGE_QINIU_DOMAIN','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'可用测试域名，但生产环境建议自定义加速域名','value'=>'','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1491964719','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'84','title'=>'后台菜单显示','type'=>'dropDownList','name'=>'SYS_MENU_SHOW_TYPE','cate'=>'2','cate_child'=>'18','extra'=>'1:只显示有权限的菜单
2:不限','remark'=>'如果选择不限会显示全部菜单，选择有权限菜单则只会显示用户权限对应的菜单','value'=>'1','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1492360156','updated'=>'1501634806']);
        $this->insert('{{%sys_config}}',['id'=>'85','title'=>'AppId','type'=>'text','name'=>'QQ_CLIENT_APPID','cate'=>'5','cate_child'=>'11','extra'=>'','remark'=>'应用的唯一标识。在OAuth2.0认证过程中，appid的值即为oauth_consumer_key的值','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1492703739','updated'=>'1497240326']);
        $this->insert('{{%sys_config}}',['id'=>'86','title'=>'AppKey','type'=>'text','name'=>'QQ_CLIENT_APPKEY','cate'=>'5','cate_child'=>'11','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1492703885','updated'=>'1501465786']);
        $this->insert('{{%sys_config}}',['id'=>'87','title'=>'AppId','type'=>'text','name'=>'WEIBO_CLIENT_APPID','cate'=>'5','cate_child'=>'12','extra'=>'','remark'=>'应用的唯一标识。在OAuth2.0认证过程中，appid的值即为oauth_consumer_key的值','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1492703971','updated'=>'1506756049']);
        $this->insert('{{%sys_config}}',['id'=>'88','title'=>'AppKey','type'=>'text','name'=>'WEIBO_CLIENT_APPKEY','cate'=>'5','cate_child'=>'12','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1492704022','updated'=>'1506756050']);
        $this->insert('{{%sys_config}}',['id'=>'89','title'=>'SMTP服务器','type'=>'text','name'=>'MAILER_HOST','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'例如:smtp.163.com','value'=>'smtp.163.com','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1492705455','updated'=>'1497230983']);
        $this->insert('{{%sys_config}}',['id'=>'90','title'=>'SMTP帐号','type'=>'text','name'=>'MAILER_USERNAME','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'例如:mobile@163.com','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1492705498','updated'=>'1501466132']);
        $this->insert('{{%sys_config}}',['id'=>'91','title'=>'SMTP客户端授权码','type'=>'password','name'=>'MAILER_PASSWORD','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'如果是163邮箱，此处要填授权码','value'=>'','is_hide_remark'=>'0','sort'=>'2','status'=>'1','append'=>'1492705543','updated'=>'1510801208']);
        $this->insert('{{%sys_config}}',['id'=>'92','title'=>'SMTP端口','type'=>'text','name'=>'MAILER_PORT','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'25、109、110、143、465、995、993','value'=>'25','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1492705597','updated'=>'1510800464']);
        $this->insert('{{%sys_config}}',['id'=>'95','title'=>'发件人名称','type'=>'text','name'=>'MAILER_NAME','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'例如:RageFrame','value'=>'rageframe','is_hide_remark'=>'0','sort'=>'5','status'=>'1','append'=>'1493707723','updated'=>'1501466230']);
        $this->insert('{{%sys_config}}',['id'=>'97','title'=>'AppId','type'=>'text','name'=>'GITHUB_CLIENT_APPID','cate'=>'5','cate_child'=>'14','extra'=>'','remark'=>'应用的唯一标识。在OAuth2.0认证过程中，appid的值即为oauth_consumer_key的值','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1495441085','updated'=>'1506756053']);
        $this->insert('{{%sys_config}}',['id'=>'98','title'=>'AppKey','type'=>'text','name'=>'GITHUB_CLIENT_APPKEY','cate'=>'5','cate_child'=>'14','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1495441133','updated'=>'1506756054']);
        $this->insert('{{%sys_config}}',['id'=>'100','title'=>'AppKey','type'=>'text','name'=>'WEIXIN_CLIENT_APPKEY','cate'=>'5','cate_child'=>'13','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','value'=>'','is_hide_remark'=>'0','sort'=>'1','status'=>'1','append'=>'1495508092','updated'=>'1506756052']);
        $this->insert('{{%sys_config}}',['id'=>'99','title'=>'AppId','type'=>'text','name'=>'WEIXIN_CLIENT_APPID','cate'=>'5','cate_child'=>'13','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1495508028','updated'=>'1506756051']);
        $this->insert('{{%sys_config}}',['id'=>'101','title'=>'联系电话','type'=>'text','name'=>'WEB_TELEPHONE','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'2','status'=>'1','append'=>'1497180795','updated'=>'1513853648']);
        $this->insert('{{%sys_config}}',['id'=>'102','title'=>'联系QQ','type'=>'text','name'=>'WEB_RETATION_QQ','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'3','status'=>'1','append'=>'1497235256','updated'=>'1513853647']);
        $this->insert('{{%sys_config}}',['id'=>'103','title'=>'使用SSL加密','type'=>'radioList','name'=>'MAILER_ENCRYPTION','cate'=>'6','cate_child'=>'16','extra'=>'0:关闭;
1:开启;','remark'=>'开启此项后，连接将用SSL的形式，此项需要SMTP服务器支持','value'=>'0','is_hide_remark'=>'0','sort'=>'4','status'=>'1','append'=>'1501212682','updated'=>'1510801616']);
        $this->insert('{{%sys_config}}',['id'=>'104','title'=>'百度自动推送','type'=>'textarea','name'=>'WEB_BAIDU_PUSH','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'自动推送网站链接给百度收录','value'=>'','is_hide_remark'=>'0','sort'=>'9','status'=>'1','append'=>'1501466488','updated'=>'1513853655']);
        $this->insert('{{%sys_config}}',['id'=>'105','title'=>'后台 Tab 页签','type'=>'radioList','name'=>'SYS_MENU_TAB','cate'=>'2','cate_child'=>'18','extra'=>'0:关闭
1:开启','remark'=>'修改后需要刷新后台才能看到效果','value'=>'1','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1501730637','updated'=>'1506492330']);
        $this->insert('{{%sys_config}}',['id'=>'112','title'=>'分享图片','type'=>'image','name'=>'WECHAT_SHARE_COVER','cate'=>'3','cate_child'=>'22','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'2','status'=>'1','append'=>'1506756118','updated'=>'1506756118']);
        $this->insert('{{%sys_config}}',['id'=>'106','title'=>'accessKeyId','type'=>'text','name'=>'STORAGE_ALI_ACCESSKEYID','cate'=>'7','cate_child'=>'21','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'0','status'=>'1','append'=>'1506748040','updated'=>'1506756060']);
        $this->insert('{{%sys_config}}',['id'=>'107','title'=>'accessKeySecret','type'=>'password','name'=>'STORAGE_ALI_ACCESSKEYSECRET','cate'=>'7','cate_child'=>'21','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'1','status'=>'1','append'=>'1506748120','updated'=>'1506756061']);
        $this->insert('{{%sys_config}}',['id'=>'108','title'=>'空间名','type'=>'text','name'=>'STORAGE_ALI_BUCKET','cate'=>'7','cate_child'=>'21','extra'=>'','remark'=>'','value'=>'rageframe','is_hide_remark'=>'1','sort'=>'2','status'=>'1','append'=>'1506748216','updated'=>'1506756062']);
        $this->insert('{{%sys_config}}',['id'=>'109','title'=>'EndPoint','type'=>'text','name'=>'STORAGE_ALI_ENDPOINT','cate'=>'7','cate_child'=>'21','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'3','status'=>'1','append'=>'1506748837','updated'=>'1506756063']);
        $this->insert('{{%sys_config}}',['id'=>'110','title'=>'分享标题','type'=>'text','name'=>'WECHAT_SHARE_TITLE','cate'=>'3','cate_child'=>'22','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'0','status'=>'1','append'=>'1506755875','updated'=>'1509584895']);
        $this->insert('{{%sys_config}}',['id'=>'111','title'=>'分享详情','type'=>'textarea','name'=>'WECHAT_SHARE_DETAILS','cate'=>'3','cate_child'=>'22','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'1','status'=>'1','append'=>'1506755948','updated'=>'1509584895']);
        $this->insert('{{%sys_config}}',['id'=>'113','title'=>'分享链接','type'=>'text','name'=>'WECHAT_SHARE_URL','cate'=>'3','cate_child'=>'22','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'3','status'=>'1','append'=>'1506756192','updated'=>'1509584895']);
        $this->insert('{{%sys_config}}',['id'=>'124','title'=>'支付证书私钥','type'=>'text','name'=>'ALIPAY_PRIVATE_KEY','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'请填写证书绝对路径','value'=>'','is_hide_remark'=>'0','sort'=>'3','status'=>'1','append'=>'1515124200','updated'=>'1515124277']);
        $this->insert('{{%sys_config}}',['id'=>'121','title'=>'支付秘钥','type'=>'text','name'=>'UNION_CERT_ID','cate'=>'4','cate_child'=>'10','extra'=>'','remark'=>'','value'=>'','is_hide_remark'=>'1','sort'=>'1','status'=>'1','append'=>'1515124116','updated'=>'1515390393']);
        $this->insert('{{%sys_config}}',['id'=>'120','title'=>'商户号','type'=>'text','name'=>'UNION_MER_ID','cate'=>'4','cate_child'=>'10','extra'=>'','remark'=>'银联商户账号','value'=>'','is_hide_remark'=>'0','sort'=>'0','status'=>'1','append'=>'1515123955','updated'=>'1515390393']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%sys_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

