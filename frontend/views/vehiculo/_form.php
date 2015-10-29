<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiculo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 've_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 've_matricula')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 've_seguro')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 've_movil')->textInput() ?>

    <?= $form->field($model, 'tv_id')->widget(Select2::className(),[
        'data' => yii\helpers\ArrayHelper::map(frontend\models\TipoVehiculo::find()->all(), 'tv_id', 'tv_nombre'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccionar un tipo de vehiculo'],
        'pluginOptions' =>[
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 've_entregaslimite')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
