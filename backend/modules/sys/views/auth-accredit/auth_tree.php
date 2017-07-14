<?php
use yii\helpers\Url;
?>
<?php foreach($models as $k => $model){ ?>
    <tr id = <?= $model['key'] ?> name ="<?= $model['name'] ?>"  class="<?php echo $parent_key ?>">
        <td>
            <?php if(!empty($model['-'])){ ?>
                <div class="fa fa-minus-square cf" style="cursor:pointer;"></div>
            <?php } ?>
        </td>
        <td>
            <?php for($i = 1;$i < $model['level'];$i++){ ?>　　
                <?php if($i == $model['level']-1) {
                    if(isset($models[$k+1])){
                        echo "├──";
                    }else{
                        echo "└──";
                    }
                }?>
            <?php } ?>
            <?php if($model['parent_key']== 0 ){ ?>
                <b><?= $model['description']?></b>&nbsp;
            <?php }else{ ?>
                <?= $model['description']?>&nbsp;
            <?php } ?>
            <a href="<?= Url::to(['edit','parent_key'=>$model['key'],'parent_title'=>$model['description'],'level'=>$model['level']+1])?>" data-toggle='modal' data-target='#ajaxModal'>
                <i class="fa fa-plus-circle"></i>
            </a>
        </td>
        <td><?= $model['name']?></td>
        <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
        <td>
            <a href="<?= Url::to(['edit','parent_key'=>$model['parent_key'],'parent_title'=>$parent_title,'name'=>$model['name']])?>" data-toggle='modal' data-target='#ajaxModal'><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
            <a href="<?= Url::to(['delete','name'=>$model['name']])?>"  onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
        </td>
    </tr>
    <?php if(!empty($model['-'])){ ?>
        <?= $this->render('auth_tree', [
            'models'=>$model['-'],
            'parent_title' =>$model['description'],
            'parent_key' => $model['key']." ".$parent_key,
        ])?>
    <?php } ?>
<?php } ?>





