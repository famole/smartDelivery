<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Reparto */

$this->title = 'Reparto: ' . $model->rep_id;
$this->params['breadcrumbs'][] = ['label' => 'Repartos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reparto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rep_id',
            've_id',
            'rep_fhini',
            'rep_fhfin',
            'est_id',
            'est_observacion',
        ],
    ]) ?>

</div>
