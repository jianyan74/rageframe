### RageFrame

为二次开发而生，让开发变得更简单。

[![Latest Stable Version](https://poser.pugx.org/jianyan74/rageframe-basics/v/stable)](https://packagist.org/packages/jianyan74/rageframe-basics)
[![Total Downloads](https://poser.pugx.org/jianyan74/rageframe-basics/downloads)](https://packagist.org/packages/jianyan74/rageframe-basics)
[![License](https://poser.pugx.org/jianyan74/rageframe-basics/license)](https://packagist.org/packages/jianyan74/rageframe-basics)

> 该版本为 1.0 版本已不在更新新功能，只修复BUG，功能已全部重构转移到 2.0 版本，更方便二次开发  
> 2.0项目地址：https://github.com/jianyan74/rageframe2

### 前言

RageFrame项目创建于2016年4月16日，基于Yii2框架开发的应用开发引擎，目前正在成长中，目的是为了集成更多的基础功能，不在为相同的基础功能重复制造轮子，开箱即用，让开发变得更加简单。

### 特色

1. 只做基础底层内容，RageFrame不会在上面开发过多的业务内容，满足绝大多数的系统底层开发。
2. 多入口模式，多入口分为 backend(后台)、frontend(PC前端)， wechat(微信)，api(其他或app接口对接)， 不同的业务,不同的设备,进入不同的入口。
3. 重写机制，系统自带的控制器模型视图以及第三方的插件和yii2框架内的文件都可以被用户重写,该重写是通过Yii2的classMap机制实现的。
4. 升级最小化干扰，RageFrame的核心文件是放到 vendor\jianyan74\rageframe-basics 路径下面，和第三方扩展，用户二次开发路径完全隔离开， RageFrame可以通过composer进行核心功能的升级，用户只需要通过composer升级 即可。
5. 对接微信公众号，使用了一款优秀的微信非官方SDK Easywechat，系统内已集成了该SDK，调用方式会在RageFrame文档说明，也可直接看其SDK文档进入深入开发。
6. RBAC(权限)管理系统，RBAC和菜单功能的无缝对接，实现无权限的菜单不对用户显示，具体参考权限和菜单添加的规则文档。
7. 插件和模块机制，安装和卸载不会对原来的系统产生影响，具体可参考RageFrame插件模块使用文档。
8. 增加了服务层Services，这样，Controller，View 层，在原则上 不能直接调用model，必须通过Services层以及子Services层，然后Services访问各个 model，组织数据，事务处理等操作，将数据结果返回给上层，这种设计可以方便以后业务 发展后，进而根据业务特点进行重构，或者以后如果出现新技术，新方式， 都重构成自己想要的样子，譬如， 将某个底层由mysql换成mongodb，或者为了应付高并发读写并且多事务性的功能部分， 进行分库分表的设计方式。
9. 整合了第三方登录，目前有QQ、微信、微博、GitHub。
10. 整合了第三方支付，目前有微信支付、支付宝支付、银联支付。
11. 框架模块支持小程序的开发。
12. 集成RESTful API，支持前后端分离接口开发和app接口开发，可直接上手开发业务。
13. 详细的文档说明，利于开发者的二次开发。

### 开始之前

- 具备 PHP 基础知识
- 具备 Yii2 基础开发知识
- 仔细阅读文档，一般常见的报错可以自行先解决，解决不了在来提问
- 如果要做微信开发需要明白微信接口的组成，自有服务器、微信服务器、公众号（还有其它各种号）、测试号、以及通信原理（交互过程）
- 如果需要做接口开发(RESTful API)了解基本的 HTTP 协议，Header 头、请求方式（`GET\POST\PUT\PATCH\DELETE`）等
- 能查看日志和Debug技能
- 一定要仔细走一遍文档

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

版权所有Copyright © 2016-2018 by RageFrame [www.rageframe.com](http://www.rageframe.com)

All rights reserved。