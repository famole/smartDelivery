<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personalcat */

$this->title = $model->pc_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Personalcats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personalcat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->pc_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->pc_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pc_id',
            'pc_desc',
        ],
    ]) ?>

</div>
