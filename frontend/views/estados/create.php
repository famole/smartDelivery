<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estados */

$this->title = Yii::t('app', 'Nuevo Estado');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estados'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
