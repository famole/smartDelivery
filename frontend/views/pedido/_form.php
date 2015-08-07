<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="error"></div>

<div class="pedido-form">    

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ped_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'cli_id')->textInput() ?>

    <?= $form->field($model, 'ped_fechahora')->textInput() ?>

    <?= $form->field($model, 'ped_direccion')->textInput(['maxlength' => 500]) ?>
    
    <?= $form->field($model, 'ped_dep')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'ped_observaciones')->textInput(['maxlength' => 1000]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Guardar') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/func.js" type="text/javascript"></script>
<script>
        var pedError = eval(<?php echo $model->ped_error; ?>) ;
        if(pedError){
            var pedFechaHora = eval(<?php echo $model->ped_fechahora; ?>);
            var pedDireccion = <?php echo json_encode($model->ped_direccion);?>;   
            
            showPedError(pedFechaHora, pedDireccion);
        }
</script>