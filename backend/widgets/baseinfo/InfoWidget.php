<?php
/**
 * 一些站点统计widget
 */
namespace backend\widgets\baseinfo;

use yii;
use yii\base\Widget;
use jianyan\basics\common\models\sys\ActionLog;
use jianyan\basics\common\models\sys\Manager;

class InfoWidget extends Widget
{
    public function run()
    {
        return $this->render('index', [
            'managerCount'      => Manager::find()->count(),
            'logCount'          => ActionLog::find()->count(),
            'managerVisitor'    => Manager::find()->sum('visit_count'),
        ]);
    }
}

?>