<?php

use yii\db\Migration;

class m170908_042134_sys_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%sys_config}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'配置ID\'',
            'name' => 'varchar(30) NOT NULL DEFAULT \'\' COMMENT \'配置名称\'',
            'type' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\' COMMENT \'配置类型\'',
            'title' => 'varchar(50) NOT NULL DEFAULT \'\' COMMENT \'配置说明\'',
            'cate' => 'int(5) unsigned NOT NULL COMMENT \'配置分组\'',
            'cate_child' => 'int(5) NULL DEFAULT \'0\' COMMENT \'具体分类\'',
            'extra' => 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'配置值\'',
            'remark' => 'varchar(1000) NOT NULL DEFAULT \'\' COMMENT \'配置说明\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'状态\'',
            'value' => 'text NULL COMMENT \'配置值\'',
            'sort' => 'int(10) unsigned NOT NULL COMMENT \'排序\'',
            'is_hide_remark' => 'tinyint(1) NULL DEFAULT \'0\' COMMENT \'是否隐藏说明\'',
            'append' => 'int(10) unsigned NOT NULL COMMENT \'创建时间\'',
            'updated' => 'int(10) unsigned NOT NULL COMMENT \'更新时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公共配置表'");
        
        /* 索引设置 */
        $this->createIndex('uk_name','{{%sys_config}}','name',1);
        $this->createIndex('type','{{%sys_config}}','type',0);
        $this->createIndex('group','{{%sys_config}}','cate',0);
        
        
        /* 表数据 */
        $this->insert('{{%sys_config}}',['id'=>'1','name'=>'WEB_SITE_TITLE','type'=>'1','title'=>'网站标题','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'网站标题前台显示标题','status'=>'1','value'=>'RageFrame应用开发引擎','sort'=>'0','is_hide_remark'=>'0','append'=>'1378898976','updated'=>'1503888193']);
        $this->insert('{{%sys_config}}',['id'=>'2','name'=>'WEB_SITE_DESCRIPTION','type'=>'4','title'=>'SEO网站描述','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'网站搜索引擎描述','status'=>'1','value'=>'','sort'=>'4','is_hide_remark'=>'0','append'=>'1378898976','updated'=>'1497239140']);
        $this->insert('{{%sys_config}}',['id'=>'3','name'=>'WEB_SITE_KEYWORD','type'=>'4','title'=>'SEO网站关键字','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'网站搜索引擎关键字,多个关键字以,号分割开 如: A,B.C','status'=>'1','value'=>'','sort'=>'5','is_hide_remark'=>'0','append'=>'1378898976','updated'=>'1497235269']);
        $this->insert('{{%sys_config}}',['id'=>'4','name'=>'SYS_SITE_CLOSE','type'=>'5','title'=>'关闭站点','cate'=>'2','cate_child'=>'18','extra'=>'0:关闭
1:开启','remark'=>'站点关闭全部用户不能访问','status'=>'1','value'=>'1','sort'=>'4','is_hide_remark'=>'0','append'=>'1378898976','updated'=>'1501730648']);
        $this->insert('{{%sys_config}}',['id'=>'5','name'=>'WEB_SITE_ICP','type'=>'1','title'=>'网站备案号','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'设置在网站底部显示的备案号，如“沪ICP备12007941号-2','status'=>'1','value'=>'浙ICP备17025911号-2','sort'=>'7','is_hide_remark'=>'0','append'=>'1378900335','updated'=>'1503385050']);
        $this->insert('{{%sys_config}}',['id'=>'7','name'=>'SYS_ALLOW_IP','type'=>'4','title'=>'后台允许访问IP','cate'=>'2','cate_child'=>'18','extra'=>'','remark'=>'多个用逗号分隔，如果不配置表示不限制IP访问','status'=>'1','value'=>'','sort'=>'5','is_hide_remark'=>'0','append'=>'1387165454','updated'=>'1501730650']);
        $this->insert('{{%sys_config}}',['id'=>'8','name'=>'WEB_COPYRIGHT_ALL','type'=>'1','title'=>'网站版权所有','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'设置在网站底部显示的版权所有','status'=>'1','value'=>'© 2016 - 2017 RageFrame All Rights Reserved.','sort'=>'6','is_hide_remark'=>'0','append'=>'1481591179','updated'=>'1499827750']);
        $this->insert('{{%sys_config}}',['id'=>'42','name'=>'ALIPAY_WIRELESS','type'=>'6','title'=>'是否开启','cate'=>'4','cate_child'=>'8','extra'=>'0:关闭,1:开启','remark'=>'支付宝账号必须支持手机网页即时到账接口, 才能使用手机支付功能,<a href=\"https://b.alipay.com/order/productDetail.htm?productId=2013080604609688\" target=\"_blank\">申请及详情请查看这里</a>','status'=>'1','value'=>'0','sort'=>'0','is_hide_remark'=>'0','append'=>'1481590972','updated'=>'1497231182']);
        $this->insert('{{%sys_config}}',['id'=>'43','name'=>'ALIPAY_ACCOUNT','type'=>'1','title'=>'收款账号','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'如果开启兑换或交易功能，请填写真实有效的支付宝账号。如账号无效或安全码有误，将导致用户支付后无法正确进行正常的交易。 如您没有支付宝帐号，<a href=\"https://memberprod.alipay.com/account/reg/enterpriseIndex.htm\" target=\"_blank\">请点击这里注册</a>','status'=>'1','value'=>'','sort'=>'1','is_hide_remark'=>'0','append'=>'1481591179','updated'=>'1497182130']);
        $this->insert('{{%sys_config}}',['id'=>'44','name'=>'ALIPAY_COOPERATOR','type'=>'1','title'=>'合作者身份','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'支付宝签约用户请在此处填写支付宝分配给您的合作者身份，签约用户的手续费按照您与支付宝官方的签约协议为准。如果您还未签约，<a href=\"https://memberprod.alipay.com/account/reg/enterpriseIndex.htm\" target=\"_blank\">请点击这里签约</a>；如果已签约,<a href=\"https://b.alipay.com/order/pidKey.htm?pid=2088501719138773&product=fastpay\" target=\"_blank\">请点击这里获取PID、Key</a>;如果在签约时出现合同模板冲突，请咨询0571-88158090','status'=>'1','value'=>'','sort'=>'2','is_hide_remark'=>'0','append'=>'1481591261','updated'=>'1497182139']);
        $this->insert('{{%sys_config}}',['id'=>'45','name'=>'ALIPAY_KEY','type'=>'1','title'=>'校验密钥','cate'=>'4','cate_child'=>'8','extra'=>'','remark'=>'填写支付宝分配给您的交易安全校验码，此校验码您可以到支付宝官方的商家服务功能处查看','status'=>'1','value'=>'','sort'=>'3','is_hide_remark'=>'1','append'=>'1481591441','updated'=>'1497231115']);
        $this->insert('{{%sys_config}}',['id'=>'50','name'=>'WECHAT_ACCOUTN','type'=>'1','title'=>'公众号帐号','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'填写公众号的帐号，一般为英文帐号','status'=>'1','value'=>'','sort'=>'0','is_hide_remark'=>'0','append'=>'1481597325','updated'=>'1497231224']);
        $this->insert('{{%sys_config}}',['id'=>'53','name'=>'WECHAT_APPID','type'=>'1','title'=>'AppId','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'请填写微信公众平台后台的AppId','status'=>'1','value'=>'','sort'=>'3','is_hide_remark'=>'0','append'=>'1481597992','updated'=>'1501330323']);
        $this->insert('{{%sys_config}}',['id'=>'57','name'=>'WECHAT_ID','type'=>'1','title'=>'原始ID','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'在给粉丝发送客服消息时,原始ID不能为空。建议您完善该选项','status'=>'1','value'=>'','sort'=>'1','is_hide_remark'=>'0','append'=>'1481598297','updated'=>'1497231228']);
        $this->insert('{{%sys_config}}',['id'=>'52','name'=>'WECHAT_RANK','type'=>'6','title'=>'级别','cate'=>'3','cate_child'=>'19','extra'=>'1:普通订阅号,2:普通服务号,3:认证订阅号,4:认证服务号/认证媒体/政府订阅号','remark'=>'注意：即使公众平台显示为“未认证”, 但只要【公众号设置】/【账号详情】下【认证情况】显示资质审核通过, 即可认定为认证号.','status'=>'1','value'=>'2','sort'=>'2','is_hide_remark'=>'0','append'=>'1481597865','updated'=>'1497247730']);
        $this->insert('{{%sys_config}}',['id'=>'54','name'=>'WECHAT_APPSERCRET','type'=>'1','title'=>'AppSecret','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'请填写微信公众平台后台的AppSecret, 只有填写这两项才能管理自定义菜单','status'=>'1','value'=>'','sort'=>'4','is_hide_remark'=>'0','append'=>'1481598058','updated'=>'1501330323']);
        $this->insert('{{%sys_config}}',['id'=>'55','name'=>'WECHAT_TOKEN','type'=>'3','title'=>'Token','cate'=>'3','cate_child'=>'19','extra'=>'32','remark'=>'与公众平台接入设置值一致，必须为英文或者数字，长度为3到32个字符. 请妥善保管, Token 泄露将可能被窃取或篡改平台的操作数据.','status'=>'1','value'=>'','sort'=>'5','is_hide_remark'=>'0','append'=>'1481598165','updated'=>'1501465722']);
        $this->insert('{{%sys_config}}',['id'=>'56','name'=>'WECHAT_ENCODINGAESKEY','type'=>'3','title'=>'EncodingAESKey','cate'=>'3','cate_child'=>'19','extra'=>'43','remark'=>'与公众平台接入设置值一致，必须为英文或者数字，长度为43个字符. 请妥善保管, EncodingAESKey 泄露将可能被窃取或篡改平台的操作数据.
','status'=>'1','value'=>'','sort'=>'6','is_hide_remark'=>'0','append'=>'1481598229','updated'=>'1501465722']);
        $this->insert('{{%sys_config}}',['id'=>'61','name'=>'WECHAT_MCHID','type'=>'1','title'=>'支付商户号','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'公众号支付请求中用于加密的密钥Key','status'=>'1','value'=>'','sort'=>'5','is_hide_remark'=>'0','append'=>'1484010596','updated'=>'1497231129']);
        $this->insert('{{%sys_config}}',['id'=>'60','name'=>'WECHAT_IS_PAY','type'=>'6','title'=>'是否开启','cate'=>'4','cate_child'=>'9','extra'=>'0:关闭,1:开启','remark'=>'你必须向微信公众平台提交企业信息以及银行账户资料，审核通过并签约后才能使用微信支付功能,<a href=\"https://mp.weixin.qq.com/paymch/readtemplate?t=mp/business/faq_tmpl\" target=\"_blank\">申请及详情请查看这里</a>','status'=>'1','value'=>'1','sort'=>'4','is_hide_remark'=>'0','append'=>'1484010415','updated'=>'1497416667']);
        $this->insert('{{%sys_config}}',['id'=>'62','name'=>'WECHAT_API_KEY','type'=>'1','title'=>'支付密钥','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'此值需要手动在腾讯商户后台API密钥保持一致。','status'=>'1','value'=>'','sort'=>'6','is_hide_remark'=>'0','append'=>'1484010645','updated'=>'1497231135']);
        $this->insert('{{%sys_config}}',['id'=>'63','name'=>'WECHAT_APICLIENT_CERT','type'=>'1','title'=>'支付证书','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'请填写证书绝对路径','status'=>'1','value'=>'','sort'=>'7','is_hide_remark'=>'0','append'=>'1484012102','updated'=>'1498224385']);
        $this->insert('{{%sys_config}}',['id'=>'64','name'=>'WECHAT_APICLIENT_KEY','type'=>'1','title'=>'支付证书私钥','cate'=>'4','cate_child'=>'9','extra'=>'','remark'=>'请填写私钥绝对路径','status'=>'1','value'=>'','sort'=>'8','is_hide_remark'=>'0','append'=>'1484012169','updated'=>'1498224417']);
        $this->insert('{{%sys_config}}',['id'=>'69','name'=>'WEB_SITE_LOGO','type'=>'8','title'=>'网站logo','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'商标','status'=>'1','value'=>'','sort'=>'1','is_hide_remark'=>'1','append'=>'1486629289','updated'=>'1503765365']);
        $this->insert('{{%sys_config}}',['id'=>'70','name'=>'SYS_MAX_LEVEL','type'=>'5','title'=>'菜单级别','cate'=>'2','cate_child'=>'18','extra'=>'1:1级;
2:2级;
3:3级;','remark'=>'无限极分类中最多分级数量,如后台菜单，前台导航等,默认为2级','status'=>'1','value'=>'2','sort'=>'1','is_hide_remark'=>'0','append'=>'1486630868','updated'=>'1497231298']);
        $this->insert('{{%sys_config}}',['id'=>'71','name'=>'SYS_PAGE','type'=>'5','title'=>'后台分页','cate'=>'2','cate_child'=>'18','extra'=>'10:10;
20:20;
30:30;
','remark'=>'每页显示记录的数量','status'=>'1','value'=>'10','sort'=>'0','is_hide_remark'=>'0','append'=>'1486631131','updated'=>'1497239638']);
        $this->insert('{{%sys_config}}',['id'=>'72','name'=>'WEB_VISIT_CODE','type'=>'4','title'=>'网站访问量统计','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'用于统计网站访问量的第三方代码','status'=>'1','value'=>'','sort'=>'8','is_hide_remark'=>'0','append'=>'1486952122','updated'=>'1497231351']);
        $this->insert('{{%sys_config}}',['id'=>'96','name'=>'WECHAT_QR_CODE','type'=>'8','title'=>'二维码','cate'=>'3','cate_child'=>'19','extra'=>'','remark'=>'微信关注二维码','status'=>'1','value'=>'','sort'=>'7','is_hide_remark'=>'0','append'=>'1495421613','updated'=>'1497231279']);
        $this->insert('{{%sys_config}}',['id'=>'82','name'=>'STORAGE_QINIU_BUCKET','type'=>'1','title'=>'空间名','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'七牛的后台管理页面自己创建的空间名','status'=>'1','value'=>'','sort'=>'3','is_hide_remark'=>'0','append'=>'1491962770','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'79','name'=>'STORAGE_QINIU_SECRECTKEY','type'=>'2','title'=>'七牛SK','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'签名密钥','status'=>'1','value'=>'','sort'=>'1','is_hide_remark'=>'0','append'=>'1491962373','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'80','name'=>'STORAGE_QINIU_ACCESSKEY','type'=>'1','title'=>'七牛AK','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'用户凭证','status'=>'1','value'=>'','sort'=>'0','is_hide_remark'=>'0','append'=>'1491962658','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'83','name'=>'STORAGE_QINIU_DOMAIN','type'=>'1','title'=>'域名','cate'=>'7','cate_child'=>'15','extra'=>'','remark'=>'可用测试域名，但生产环境建议自定义加速域名','status'=>'1','value'=>'','sort'=>'2','is_hide_remark'=>'0','append'=>'1491964719','updated'=>'1501466309']);
        $this->insert('{{%sys_config}}',['id'=>'84','name'=>'SYS_MENU_SHOW_TYPE','type'=>'5','title'=>'后台菜单显示','cate'=>'2','cate_child'=>'18','extra'=>'1:只显示有权限的菜单
2:不限','remark'=>'如果选择不限会显示全部菜单，选择有权限菜单则只会显示用户权限对应的菜单','status'=>'1','value'=>'1','sort'=>'2','is_hide_remark'=>'0','append'=>'1492360156','updated'=>'1501634806']);
        $this->insert('{{%sys_config}}',['id'=>'85','name'=>'QQ_CLIENT_APPID','type'=>'1','title'=>'AppId','cate'=>'5','cate_child'=>'11','extra'=>'','remark'=>'应用的唯一标识。在OAuth2.0认证过程中，appid的值即为oauth_consumer_key的值','status'=>'1','value'=>'','sort'=>'0','is_hide_remark'=>'0','append'=>'1492703739','updated'=>'1497240326']);
        $this->insert('{{%sys_config}}',['id'=>'86','name'=>'QQ_CLIENT_APPKEY','type'=>'1','title'=>'AppKey','cate'=>'5','cate_child'=>'11','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','status'=>'1','value'=>'','sort'=>'1','is_hide_remark'=>'0','append'=>'1492703885','updated'=>'1501465786']);
        $this->insert('{{%sys_config}}',['id'=>'87','name'=>'WEIBO_CLIENT_APPID','type'=>'1','title'=>'AppId','cate'=>'5','cate_child'=>'12','extra'=>'','remark'=>'应用的唯一标识。在OAuth2.0认证过程中，appid的值即为oauth_consumer_key的值','status'=>'1','value'=>'','sort'=>'2','is_hide_remark'=>'0','append'=>'1492703971','updated'=>'1497231045']);
        $this->insert('{{%sys_config}}',['id'=>'88','name'=>'WEIBO_CLIENT_APPKEY','type'=>'1','title'=>'AppKey','cate'=>'5','cate_child'=>'12','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','status'=>'1','value'=>'','sort'=>'3','is_hide_remark'=>'0','append'=>'1492704022','updated'=>'1497231052']);
        $this->insert('{{%sys_config}}',['id'=>'89','name'=>'MAILER_HOST','type'=>'1','title'=>'SMTP服务器','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'例如:smtp.163.com','status'=>'1','value'=>'','sort'=>'0','is_hide_remark'=>'0','append'=>'1492705455','updated'=>'1497230983']);
        $this->insert('{{%sys_config}}',['id'=>'90','name'=>'MAILER_USERNAME','type'=>'1','title'=>'SMTP帐号','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'例如:mobile@163.com','status'=>'1','value'=>'','sort'=>'1','is_hide_remark'=>'0','append'=>'1492705498','updated'=>'1501466132']);
        $this->insert('{{%sys_config}}',['id'=>'91','name'=>'MAILER_PASSWORD','type'=>'2','title'=>'SMTP客户端授权码','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'如果是163邮箱，此处要填授权码','status'=>'1','value'=>'','sort'=>'2','is_hide_remark'=>'0','append'=>'1492705543','updated'=>'1497230995']);
        $this->insert('{{%sys_config}}',['id'=>'92','name'=>'MAILER_PORT','type'=>'1','title'=>'SMTP端口','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'25、109、110、143、465、995、993','status'=>'1','value'=>'','sort'=>'3','is_hide_remark'=>'0','append'=>'1492705597','updated'=>'1501466118']);
        $this->insert('{{%sys_config}}',['id'=>'95','name'=>'MAILER_NAME','type'=>'1','title'=>'发件人名称','cate'=>'6','cate_child'=>'16','extra'=>'','remark'=>'例如:RageFrame','status'=>'1','value'=>'','sort'=>'5','is_hide_remark'=>'0','append'=>'1493707723','updated'=>'1501466230']);
        $this->insert('{{%sys_config}}',['id'=>'97','name'=>'GITHUB_CLIENT_APPID','type'=>'1','title'=>'AppId','cate'=>'5','cate_child'=>'14','extra'=>'','remark'=>'应用的唯一标识。在OAuth2.0认证过程中，appid的值即为oauth_consumer_key的值','status'=>'1','value'=>'','sort'=>'6','is_hide_remark'=>'0','append'=>'1495441085','updated'=>'1497231082']);
        $this->insert('{{%sys_config}}',['id'=>'98','name'=>'GITHUB_CLIENT_APPKEY','type'=>'1','title'=>'AppKey','cate'=>'5','cate_child'=>'14','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','status'=>'1','value'=>'','sort'=>'7','is_hide_remark'=>'0','append'=>'1495441133','updated'=>'1497231099']);
        $this->insert('{{%sys_config}}',['id'=>'100','name'=>'WEIXIN_CLIENT_APPKEY','type'=>'1','title'=>'AppKey','cate'=>'5','cate_child'=>'13','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','status'=>'1','value'=>'','sort'=>'5','is_hide_remark'=>'0','append'=>'1495508092','updated'=>'1497240326']);
        $this->insert('{{%sys_config}}',['id'=>'99','name'=>'WEIXIN_CLIENT_APPID','type'=>'1','title'=>'AppId','cate'=>'5','cate_child'=>'13','extra'=>'','remark'=>'appid对应的密钥，访问用户资源时用来验证应用的合法性。在OAuth2.0认证过程中，appkey的值即为oauth_consumer_secret的值','status'=>'1','value'=>'','sort'=>'4','is_hide_remark'=>'0','append'=>'1495508028','updated'=>'1497240326']);
        $this->insert('{{%sys_config}}',['id'=>'101','name'=>'WEB_TELEPHONE','type'=>'1','title'=>'联系电话','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'','status'=>'1','value'=>'','sort'=>'2','is_hide_remark'=>'1','append'=>'1497180795','updated'=>'1497238306']);
        $this->insert('{{%sys_config}}',['id'=>'102','name'=>'WEB_RETATION_QQ','type'=>'1','title'=>'联系QQ','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'','status'=>'1','value'=>'','sort'=>'3','is_hide_remark'=>'1','append'=>'1497235256','updated'=>'1497238306']);
        $this->insert('{{%sys_config}}',['id'=>'103','name'=>'MAILER_ENCRYPTION','type'=>'6','title'=>'使用SSL加密','cate'=>'6','cate_child'=>'16','extra'=>'0:关闭;
1:开启;','remark'=>'开启此项后，连接将用SSL的形式，此项需要SMTP服务器支持','status'=>'1','value'=>'1','sort'=>'4','is_hide_remark'=>'0','append'=>'1501212682','updated'=>'1501218289']);
        $this->insert('{{%sys_config}}',['id'=>'104','name'=>'WEB_BAIDU_PUSH','type'=>'4','title'=>'百度自动推送','cate'=>'1','cate_child'=>'17','extra'=>'','remark'=>'自动推送网站链接给百度收录','status'=>'1','value'=>'','sort'=>'9','is_hide_remark'=>'0','append'=>'1501466488','updated'=>'1501625204']);
        $this->insert('{{%sys_config}}',['id'=>'105','name'=>'SYS_MENU_TAB','type'=>'6','title'=>'后台 Tab 页签','cate'=>'2','cate_child'=>'18','extra'=>'0:关闭
1:开启','remark'=>'修改后需要刷新后台才能看到效果','status'=>'1','value'=>'1','sort'=>'3','is_hide_remark'=>'0','append'=>'1501730637','updated'=>'1504663222']);
        
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

