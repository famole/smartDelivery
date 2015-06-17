<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estados */

$this->title = "Estado";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estados'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'est_id',
            'est_nom',
        ],
    ]) ?>
    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->est_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->est_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar el estado?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
