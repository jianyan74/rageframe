<?php
use common\helpers\AddonsUrl;

?>
<?php foreach($models as $k => $model){ ?>
    <tr id="<?= $model['single_id']?>" class="<?php echo $pid?>">
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
            <?php if($model['pid']==0){ ?>
                <b><?= $model['title']?></b>&nbsp;
            <?php }else{ ?>
                <?= $model['title']?>&nbsp;
            <?php } ?>
            <a href="<?= AddonsUrl::to(['edit','pid'=>$model['single_id'],'parent_title'=>$model['title'],'level'=>$model['level']+1])?>">
                <i class="fa fa-plus-circle"></i>
            </a>
        </td>
        <td><?= $model['view']?></td>
        <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
        <td>
            <a href="<?= AddonsUrl::to(['edit','single_id'=>$model['single_id'],'parent_title'=>$parent_title])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
            <?php echo $model['status'] == -1 ? '<span class="btn btn-primary btn-sm" onclick="status(this)">启用</span>': '<span class="btn btn-default btn-sm"  onclick="status(this)">禁用</span>' ;?>
            <a href="<?= AddonsUrl::to(['delete','single_id'=>$model['single_id']])?>"  onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
        </td>
    </tr>
    <?php if(!empty($model['-'])){ ?>
            <?= $this->render('tree', [
                'models'=>$model['-'],
                'parent_title' =>$model['title'],
                'pid' => $model['single_id']." ".$pid,
            ])?>
    <?php } ?>
<?php } ?>




