<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\numeradores */

$this->title = Yii::t('app', 'Create Numeradores');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Numeradores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="numeradores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
