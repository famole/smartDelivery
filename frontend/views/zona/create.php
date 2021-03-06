<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\zona */

$this->title = Yii::t('app', 'Crear Zona');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zonas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zona-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
