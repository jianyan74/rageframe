<?php
use yii\helpers\Url;
?>
<?php foreach($models as $k => $model){ ?>
    <tr id = <?= $model['cate_id']?>  class="<?php echo $pid?>">
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
            <!--禁止显示二级分类再次添加三级分类-->
            <?php if($model['pid']==0){ ?>
            <a href="<?= Url::to(['edit','pid'=>$model['cate_id'],'parent_title'=>$model['title'],'level'=>$model['level']+1])?>" data-toggle='modal' data-target='#ajaxModal'>
                <i class="fa fa-plus-circle"></i>
            </a>
            <?php } ?>
        </td>
        <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="sort(this)"></td>
        <td>
            <a href="<?= Url::to(['edit','cate_id'=>$model['cate_id'],'parent_title'=>$parent_title])?>" data-toggle='modal' data-target='#ajaxModal'><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
            <?php echo $model['status'] == -1 ? '<span class="btn btn-primary btn-sm" onclick="status(this)">启用</span>': '<span class="btn btn-default btn-sm"  onclick="status(this)">禁用</span>' ;?>
            <a href="<?= Url::to(['delete','cate_id'=>$model['cate_id']])?>"  onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
        </td>
    </tr>
    <?php if(!empty($model['-'])){ ?>
        <?= $this->render('tree', [
            'models'=>$model['-'],
            'parent_title' =>$model['title'],
            'pid' => $model['cate_id']." ".$pid,
        ])?>
    <?php } ?>
<?php } ?>




