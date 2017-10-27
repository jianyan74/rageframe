<div class="multi-container">
    <div class="file-list clearfix">
        <div class="form-group" data-name ="<?= $name?>" data-boxId ="<?= $boxId?>">
            <div class="col-sm-12 input-group">
                <input class="form-control" disabled placeholder="请选择文件进行上传" type="text">
                <input name="<?= $name?>" value="<?= $value?>" type="hidden">
                <span class="input-group-btn">
                    <span class="upload-album-<?= $boxId?> btn-white"> 文件上传</span>
                </span>
            </div>
            <div class="col-sm-12" id="<?= $boxId?>">
                <?php if($value){ ?>
                <?php if($options['multiple'] == true){ ?>
                        <?php foreach ($value as $vo){ ?>
                            <div class="file-default-box">
                                <input name="<?= $name?>" value="<?= $vo?>" type="hidden">
                                <i class="fa fa-file"></i>
                                <div class="file-delimg"></div>
                            </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="file-default-box">
                            <input name="<?= $name?>" value="<?= $value?>" type="hidden">
                            <i class="fa fa-file"></i>
                            <div class="file-delimg"></div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="file-default-box file-default">
                        <input name="<?= $name?>" value="" type="hidden">
                        <i class="fa fa-cloud-upload"></i>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs(<<<Js
$(".upload-album-{$boxId}").InitMultiUploader({$config});
Js
);
?>
