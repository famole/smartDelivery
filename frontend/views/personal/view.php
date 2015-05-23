<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personal */

$this->title = $model->per_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Personals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->per_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->per_id], [
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
            'per_id',
            'user_id',
            'per_nom',
            'per_priape',
            'per_segape',
            'per_tel',
            'pc_id',
        ],
    ]) ?>

</div>
