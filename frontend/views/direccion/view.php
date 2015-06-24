<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Direccion */

$this->title = $model->dir_direccion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Direccion'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direccion-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dir_id',
            'dir_direccion',
            'dir_latlong',
        ],
    ]) ?>
    
      <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->dir_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->dir_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar la direccion?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
