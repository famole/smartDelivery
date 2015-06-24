<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\parametros */

$this->title = $model->parm_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parametros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'parm_id',
            'parm_num',
            'parm_text',
        ],
    ]) ?>
    
     <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->parm_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->parm_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar el parametro?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
