<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personal */

$this->title = $model->per_nom . ' ' . $model->per_priape;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Personal'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'per_id',
            'user_id',
            'per_nom',
            'per_priape',
            'per_segape',
            'per_tel',
            'pc_id',
        ],
    ]) ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->per_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->per_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar la Persona?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
