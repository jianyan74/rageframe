<div class="multi-container">
    <div class="photo-list clearfix">
        <ul data-name ="<?= $name?>" data-boxId ="<?= $boxId?>">
            <?php if($options['multiple'] == true){ ?>
                <?php if($value){ ?>
                    <?php foreach ($value as $vo){ ?>
                        <?php if($vo){ ?>
                            <li class="social-avatar">
                                <input name="<?= $name?>" value="<?= $vo?>" type="hidden">
                                <div class="img-box">
                                    <a class="fancybox" href="<?= trim($vo) ?>">
                                        <img src="<?= $vo?>">
                                    </a>
                                    <i class="delimg" data-multiple="<?= $options['multiple']?>"></i>
                                </div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <li class="upload-box upload-album-<?= $boxId?> social-avatar"></li>
            <?php }else{ ?>
                <?php if($value){ ?>
                    <li class="social-avatar">
                        <input name="<?= $name?>" value="<?= $value?>" type="hidden">
                        <div class="img-box">
                            <a class="fancybox" href="<?= $value ?>">
                                <img src="<?= $value?>">
                            </a>
                            <i class="delimg" data-multiple="<?= $options['multiple']?>"></i>
                        </div>
                    </li>
                <?php } ?>
                <li class="upload-box upload-album-<?= $boxId?> social-avatar" <?php if(!empty($value)){?>style="display: none"<?php } ?>></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php $this->registerJs(<<<Js
$(".upload-album-{$boxId}").InitMultiUploader({
    filesize    : "{$pluginOptions['uploadMaxSize']}",
    server      : "{$pluginOptions['uploadUrl']}",
    mimeTypes   : "{$options['mimeTypes']}",
    multiple    : "{$options['multiple']}",
    extensions  : "{$options['extensions']}",
    name        : "{$name}",
    boxId       : "{$boxId}",
});
//图片弹出框
$(".fancybox").fancybox({
    openEffect:"none",
    closeEffect:"none"
});
Js
);
?>
