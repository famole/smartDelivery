<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PersonalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'per_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'per_nom') ?>

    <?= $form->field($model, 'per_priape') ?>

    <?= $form->field($model, 'per_segape') ?>

    <?php // echo $form->field($model, 'per_tel') ?>

    <?php // echo $form->field($model, 'pc_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
