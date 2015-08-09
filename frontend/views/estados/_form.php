<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\enum\EnumStatusType;

/* @var $this yii\web\View */
/* @var $model app\models\Estados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'est_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'est_nom')->textInput(['maxlength' => 100]) ?>
    
    <?= $form->field($model, 'est_type')->dropDownList([
        'prompt'=>'Seleccionar',
        EnumStatusType::Entrega => 'Entrega',
        EnumStatusType::Pedido => 'Pedido',
        EnumStatusType::Reparto => 'Reparto',
        EnumStatusType::System => 'Sistema']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Guardar') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
