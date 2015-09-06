<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Personalcat */

$this->title = Yii::t('app', 'Crear Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personalcat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
