<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoVehiculo */

$this->title = Yii::t('app', 'Crear Tipo Vehiculo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Vehiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-vehiculo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
