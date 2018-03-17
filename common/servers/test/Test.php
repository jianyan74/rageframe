<?php
namespace common\servers\test;

use jianyan\basics\services\Service;

/**
 * Class Test
 * @package common\servers
 */
class Test extends Service
{
   public function index()
   {
       var_dump("调用服务成功2");
   }
}