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
                                    <a href="<?= trim($vo) ?>" data-fancybox="gallery">
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
                            <a href="<?= $value ?>" data-fancybox="gallery">
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
    $(".upload-album-{$boxId}").InitMultiUploader({$config});
    
    $("[data-fancybox]").fancybox({
        // Options will go here
        toolbar  : true,//工具栏
        buttons : [
            'slideShow',
            'fullScreen',
            'thumbs',
            //'download',
            //'share',
            'close'
        ]
    });
Js
);
?>
