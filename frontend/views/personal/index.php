<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PersonalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Trabajar con Personal');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Alta Persona'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'per_id',
            //'user_id',
            'per_nom',
            'per_priape',
            //'per_segape',
            // 'per_tel',
            // 'pc_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
