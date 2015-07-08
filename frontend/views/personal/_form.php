<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'per_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'per_nom')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'per_priape')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'per_segape')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'per_tel')->textInput() ?>

    <?= $form->field($model, 'pc_id')->widget(Select2::className(),[
        'data' => yii\helpers\ArrayHelper::map(app\models\Personalcat::find()->all(), 'pc_id', 'pc_desc'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccionar una categoria'],
        'pluginOptions' =>[
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Guardar') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
