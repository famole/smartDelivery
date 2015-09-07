<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personalcat */

$this->title = 'Categoria: ' . $model->pc_desc;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];

?>
<div class="personalcat-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pc_id',
            'pc_desc',
        ],
    ]) ?>
    
    
    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->pc_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->pc_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar la categoria?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
