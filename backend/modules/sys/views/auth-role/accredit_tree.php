<div class="checkbox checkbox-inline" style="padding-left: 25px">
    <?php foreach($models as $key => $item){ ?>
        <?php if(!empty($item['-']) && empty($models[abs($key - 1)]['-'])){ ?><br><?php } ?>
        <label class="checkbox-inline i-checks">
            <div class="icheckbox_square-green" style="position: relative;">
                <input type="checkbox" value="<?= $item['name']?>" name="auth[]" <?php if(!empty($item['authItemChildren0'])){?>checked="checked"<?php } ?>>
            </div><?= $item['description']?>
        </label>
        <?php if(!empty($item['-'])){ ?>
            <div class="row" style="padding-left: 15px">
                <?= $this->render('accredit_tree', [
                    'models'=>$item['-'],
                ]) ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>



