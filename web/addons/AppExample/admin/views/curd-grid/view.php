<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model addons\AppExample\common\models\Curd */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Curds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'cate_id',
            'manager_id',
            'sort',
            'position',
            'sex',
            'content:ntext',
            'cover',
            'covers',
            'attachfile',
            'keywords',
            'description',
            'price',
            'views',
            'stat_time:datetime',
            'end_time:datetime',
            'status',
            'email:email',
            'provinces',
            'city',
            'area',
            'ip',
            'append',
            'updated',
        ],
    ]) ?>

</div>
