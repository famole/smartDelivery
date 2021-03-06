<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\parametros */

$this->title = 'Actualizar: ' . $model->parm_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parametros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parm_id, 'url' => ['view', 'id' => $model->parm_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="parametros-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
