<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TurnosEntrega */

$this->title = $model->te_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Turnos Entregas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnos-entrega-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->te_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->te_id], [
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
            'te_id',
            'te_nombre',
            'te_horainicio',
            'te_horafin',
        ],
    ]) ?>

</div>
