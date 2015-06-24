<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\parametros */

$this->title = Yii::t('app', 'Crear Parametro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parametros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
