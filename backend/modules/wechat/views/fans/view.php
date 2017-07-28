<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\wechat\Fans;

$this->title = '粉丝列表';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
    <h4 class="modal-title">详细信息</h4>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <td class="feed-element">
                        <img src="<?= $model->headimgurl ?>" class="img-circle">
                    </td>
                    <td><?= $model['nickname']?></td>
                </tr>
                <tr>
                    <td>粉丝编号</td>
                    <td><?= $model['openid']?></td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td><?= $model->sex == 1 ? '男' : '女' ?></td>
                </tr>
                <tr>
                    <td>是否关注</td>
                    <td>
                        <?php if($model->follow == Fans::FOLLOW_OFF){ ?>
                            <span class="label label-danger">已取消</span>
                        <?php }else{ ?>
                            <span class="label label-info">已关注</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>关注/取消时间</td>
                    <td>
                        <?php if($model->follow == Fans::FOLLOW_OFF){ ?>
                            <?= Yii::$app->formatter->asDatetime($model->unfollowtime) ?>
                        <?php }else{ ?>
                            <?= Yii::$app->formatter->asDatetime($model->followtime) ?>
                        <?php } ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
</div>