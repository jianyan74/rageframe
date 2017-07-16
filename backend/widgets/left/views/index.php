<?php
use yii\helpers\Url;

?>
<style>.fa-with{min-width: 15px;}</style>
<?php foreach($models as $item){ ?>
    <?php if($item['id'] != 108){ ?>
        <li>
            <?php if(!empty($item['-'])){ ?>
                <a href="#">
                    <i class="fa <?= $item['menu_css']?> fa-with"></i>
                    <span class="nav-label"><?= $item['title']?></span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <?php foreach($item['-'] as $list){ ?>
                        <li>
                            <?php if(!empty($list['-'])){ ?>
                                <a href="#"><?= $list['title']?> <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <?php foreach($list['-'] as $loop){ ?>
                                        <li><a class="J_menuItem" href="<?= Url::toRoute($loop['url'])?>"><?= $loop['title']?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php }else{ ?>
                                <a class="J_menuItem" href="<?= Url::toRoute($list['url'])?>"><?= $list['title']?></a>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php }else{ ?>
                <a class="J_menuItem" href="<?= Url::toRoute($item['url'])?>">
                    <i class="fa <?php if(!empty($item['menu_css'])){ ?><?= $item['menu_css']?><?php }else{ ?>fa fa-magic<?php } ?> fa-with"></i>
                    <span class="nav-label"><?= $item['title']?></span>
                </a>
            <?php } ?>
        </li>
    <?php }else{ ?>
        <li>
            <a href="#">
                <i class="fa <?= $item['menu_css']?> fa-with"></i>
                <span class="nav-label"><?= $item['title']?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <?php foreach($plug as $list){ ?>
                    <li>
                        <a class="J_menuItem" href="<?php echo Url::to(['sys/addons/binding','addon' => $list['name']])?>"><?= $list['title']?></a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
<?php } ?>
