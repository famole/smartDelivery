<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EntregaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entrega-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ent_id') ?>

    <?= $form->field($model, 'ped_id') ?>

    <?= $form->field($model, 'z_id') ?>

    <?= $form->field($model, 'ent_pendefinir') ?>

    <?= $form->field($model, 'te_id') ?>

    <?php // echo $form->field($model, 'est_id') ?>

    <?php // echo $form->field($model, 'ent_obs') ?>

    <?php // echo $form->field($model, 'ent_fecha') ?>

    <?php // echo $form->field($model, 'dir_id') ?>

    <?php // echo $form->field($model, 'ent_errorDesc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
