<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ClienteDireccion */

$this->title = Yii::t('app', 'Create Cliente Direccion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cliente Direccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-direccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
