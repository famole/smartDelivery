<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Direccion */

$this->title = Yii::t('app', 'Create Direccion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Direccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
