<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */

$this->title = Yii::t('app', 'Crear Vehiculo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vehiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
