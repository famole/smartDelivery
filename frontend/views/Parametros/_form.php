<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\parametros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametros-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parm_id')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'parm_num')->textInput() ?>

    <?= $form->field($model, 'parm_text')->textInput(['maxlength' => 500]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
