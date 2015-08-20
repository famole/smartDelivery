<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepartoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reparto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rep_id') ?>

    <?= $form->field($model, 've_id') ?>

    <?= $form->field($model, 'rep_fhini') ?>

    <?= $form->field($model, 'rep_fhfin') ?>

    <?= $form->field($model, 'est_id') ?>

    <?php // echo $form->field($model, 'est_observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
