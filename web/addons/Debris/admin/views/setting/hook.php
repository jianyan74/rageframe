<?php
use addons\Debris\common\models\Debris;

?>

<?php if($model['type'] == Debris::TYPE_CHARACTER){ ?><!--文字-->

    <?php echo $model['character'] ?>

<?php }elseif($model['type'] == Debris::TYPE_COVER){ ?><!--图片-->

    <?php echo $model['cover'] ?>

<?php }elseif($model['type'] == Debris::TYPE_CONTENT){ ?><!--图文-->

    <?php echo htmlspecialchars_decode($model['content']) ?>

<?php } ?>