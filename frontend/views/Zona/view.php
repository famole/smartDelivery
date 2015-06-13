<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */

$this->title = $model->z_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zonas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zona-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->z_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->z_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'z_id',
            'z_nombre',
            'z_zona',
        ],
    ]) ?>

</div>
