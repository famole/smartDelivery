<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Entrega */


$this->params['breadcrumbs'][] = ['label' => 'Entregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detalle Entrega';
?>
<div class="entrega-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ent_id',
            'ped_id',
            [
                'label' => 'Direccion',
                'value' => $model->direccion->dir_direccion
            ],
            [
                'label' => 'Zona',
                'value' => $model->zona->z_nombre
            ],
            [
                'label' => 'Turno Entrega',
                'value' => $model->turnoEntrega->te_nombre
            ],
            [
                'label' => 'Estado',
                'value' => $model->estados->est_nom
            ],
            'ent_obs',
            'ent_fecha',
        ],
    ]) ?>

</div>
