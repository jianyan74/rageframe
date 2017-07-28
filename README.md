### RageFrame
为二次开发而生，让开发变得更简单。

### 前言
RageFrame项目创建于2016年4月16日，基于Yii2框架，目前正在开发中，目的是为了集成更多的基础功能，不在为相同的基础功能重复制造轮子，开箱即用，让开发变得更加简单。

### 特色
1. 多入口模式，多入口分为 backend(后台)、frontend(PC前端)， wechat(微信)，api(其他接口对接)， 不同的业务,不同的设备,进入不同的入口
2. 重写机制，框架自带的控制器模型以及第三方的插件和yii2框架内的文件都可以被用户重写,该重写是通过Yii2的classMap机制实现的
3. 对接微信公众号，使用了一款优秀的微信非官方SDK Easywechat，系统内已集成了该SDK，调用方式会在RageFrame文档说明，也可直接看其SDK文档进入深入开发
4. RBAC(权限)管理系统,RBAC和菜单功能的无缝对接，实现无权限的菜单不对用户显示，具体参考权限和菜单添加的规则文档
5. 只做基础底层内容，不会再上面开发过多的业务内容,使其可以满足绝大多数的系统开发
6. 插件和模块机制，安装和卸载不会对原来的系统产生影响,具体可参考RageFrame插件模块使用文档
7. 整合了第三方登录，目前有QQ、微信、微博、GitHub
8. 整合了第三方支付，目前只有微信支付，后续会接入其它支付

### 官网

http://rageframe.com

### 开发文档

[RageFrame 开发文档](http://rageframe.com/addons/execute.html?route=manual/index&addon=AppManual)

### Demo

http://demo.rageframe.com/backend

账号：demo

密码：1234567

> demo限制了一些功能,为了更好的体验功能请下载安装体验

### 问题反馈

在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

QQ群：[655084090](https://jq.qq.com/?_wv=1027&k=4BeVA2r)

Email：751393839@qq.com

论坛：http://forum.rageframe.com

Github：https://github.com/jianyan74/rageframe.git

Git@OSC：https://git.oschina.net/jianyan94/rageframe.git

### 特别鸣谢

感谢以下的项目,排名不分先后

Yii：http://www.yiiframework.com/

Bootstrap：http://getbootstrap.com

EasyWechat：https://easywechat.org/

### 版权信息

RageFrame遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2016-2017 by RageFrame [www.rageframe.com](http://www.rageframe.com)

All rights reserved。