<?php
namespace backend\widgets\notify;

use yii;
use yii\base\Widget;
use common\models\sys\Notify;
use common\models\sys\NotifyManager;
use yii\data\Pagination;

class NotifyWidget extends Widget
{
    public function run()
    {
        $notifyManager = NotifyManager::getNotifyManager();

        //公告
        $data = Notify::find()->where(['and',['type'=>Notify::TYPE_ANNOUNCE],['>=','append',$notifyManager['last_announce_time']]]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => 5 ]);
        $notify = $data->offset($pages->offset)
            ->with('manager')
            ->orderBy('append desc')
            ->select('id,title,type,sender,append')
            ->limit($pages->limit)
            ->all();

        //私信
        $message = Notify::find()->where(['and',['type'=>Notify::TYPE_MESSAGE],['target'=>Yii::$app->user->id],['>=','append',$notifyManager['last_message_time']]]);
        $messagePages = new Pagination(['totalCount' =>$message->count(), 'pageSize' => 5 ]);
        $messageData = $message->offset($messagePages->offset)
            ->with('manager')
            ->orderBy('append desc')
            ->select('id,content,type,sender,append')
            ->limit($messagePages->limit)
            ->asArray()
            ->all();

        return $this->render('index', [
            'notify' => $notify,
            'message' => $messageData,
            'notify_pages' => $pages,
            'message_pages' => $messagePages,
        ]);
    }
}

?>