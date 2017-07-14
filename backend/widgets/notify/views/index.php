<?php
use yii\helpers\Url;

?>

<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-envelope"></i>
        <span class="label label-warning" id="notify-announce"><?= $notify_pages->totalCount ?></span>
    </a>
    <ul class="dropdown-menu dropdown-alerts" id="announce-menu">
        <?php if($notify){ ?>
            <?php foreach ($notify as $vo){ ?>
                <li class="m-t-xs">
                    <div class="dropdown-messages-box">
                        <div class="media-body">
                            <strong><?= $vo['manager']['username'] ?></strong> <?= $vo['title']?>
                            <br>
                            <small class="text-muted"><?php echo Yii::$app->formatter->asRelativeTime($vo['append'])?> <?php echo Yii::$app->formatter->asDate($vo['append'])?></small>
                        </div>
                    </div>
                </li>
                <li class="divider"></li>
            <?php }?>
        <?php }?>
        <li class="other-li" style="display: <?= $notify ? 'none' : 'block';?>">
            <a href="javascript:;void(0)">
                <div>
                    暂无最新公告
                </div>
            </a>
        </li>
        <li class="divider other-li" style="display:<?= $notify ? 'none' : 'block';?>"></li>
        <li class="other-li">
            <div class="text-center link-block">
                <a class="J_menuItem" href="<?= Url::to(['sys/notify-announce/personal'])?>" onclick="announce()">
                    <i class="fa fa-envelope"></i>
                    <strong> 全部公告</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-bell"></i>
        <span class="label label-primary" id="notify-message"><?= $message_pages->totalCount ?></span>
    </a>
    <ul class="dropdown-menu dropdown-alerts" id="message-menu">
        <?php if($message){ ?>
            <?php foreach ($message as $vo){ ?>
                <li class="m-t-xs">
                    <div class="dropdown-messages-box">
                        <div class="media-body">
                            <strong><?= $vo['manager']['username'] ?></strong> 发来了一条私信
                            <br>
                            <small class="text-muted"><?php echo Yii::$app->formatter->asRelativeTime($vo['append'])?> <?php echo Yii::$app->formatter->asDate($vo['append'])?></small>
                        </div>
                    </div>
                </li>
                <li class="divider"></li>
            <?php }?>
        <?php }?>
        <li class="other-li" style="display: <?= $message ? 'none' : 'block';?>">
            <a href="javascript:;void(0)">
                <div>
                    暂无最新消息
                </div>
            </a>
        </li>
        <li class="divider other-li" style="display:<?= $message ? 'none' : 'block';?>"></li>
        <li class="other-li">
            <div class="text-center link-block">
                <a class="J_menuItem" href="<?= Url::to(['sys/notify-message/personal'])?>" onclick="message()">
                    <i class="fa fa-bell"></i>
                    <strong>全部消息 </strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>

<script>
    function announce(){
        $('body').click();
        $('#notify-announce').text(0);
        $('#announce-menu').find('li').hide();
        $('#announce-menu').find('.other-li').show();
    }

    function message(){
        $('body').click();
        $('#notify-message').text(0);
        $('#message-menu').find('li').hide();
        $('#message-menu').find('.other-li').show();
    }
</script>