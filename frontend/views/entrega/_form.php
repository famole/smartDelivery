<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Entrega */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entrega-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ent_id')->textInput() ?>

    <?= $form->field($model, 'ped_id')->textInput() ?>

    <?= $form->field($model, 'z_id')->textInput() ?>

    <?= $form->field($model, 'ent_pendefinir')->textInput() ?>

    <?= $form->field($model, 'te_id')->textInput() ?>

    <?= $form->field($model, 'est_id')->textInput() ?>

    <?= $form->field($model, 'ent_obs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ent_fecha')->textInput() ?>

    <?= $form->field($model, 'dir_id')->textInput() ?>

    <?= $form->field($model, 'ent_errorDesc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
