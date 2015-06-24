<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Personal */

$this->title = Yii::t('app', 'Nueva Persona');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nueva Persona'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
