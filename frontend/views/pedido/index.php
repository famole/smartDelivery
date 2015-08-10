<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile(Yii::$app->request->BaseUrl . '/dist/spin.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->BaseUrl . '/dist/ladda.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->BaseUrl . '/js/alert.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->title = Yii::t('app', 'Pedidos');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pedido-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="form-group">
        <div id="alert" class="msg-top"></div>
        <button type="button" id="process" class="btn btn-primary ladda-button" data-style="zoom-out" name="submit">
            <span class="ladda-label">Procesar Pedidos</span>
            <span class="ladda-spinner"></span>
        </button>
    </div>

    
    <?php Pjax::begin(['id'=>'pedidos-grid'])?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions'=>function($model){
                    if($model->ped_error == 1){
                        return ['class' => 'danger'];
                    }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'ped_id',
                'cli_id',
                [
                    'attribute' => 'ped_fechahora',
                    'format' => ['date','dd-MM-Y H:i:s'],
                ],
                'ped_direccion',
                'ped_observaciones',
                
                ['class' => 'yii\grid\ActionColumn',
                 'template' => '{update}',
                  'buttons' => [
                    'update' => function ($url,$model) {
                        if($model->ped_error == 1){
                            return Html::a('<span class="glyphicon glyphicon-exclamation-sign"></span>', $url);
                        }else{
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        }
                    }],
            ],],
        ]);?>
    <?php Pjax::end()?>
</div>

<?php

    $script=<<<JS
        $( document ).ready(function() {
            
        $('#process').click(function(e) {
             var l = Ladda.create( document.querySelector( '.ladda-button' ) );
             l.start();
             $.get('index.php?r=process/process-pedidos', function(data){  
                var msg = '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Se proceso(aron) '+ data.pedidos + ' pedido(s) y se encontro ' + data.errores +' error(es).</div>';
   
                switch(data.pedidos) {
                    case 0:
                        msg = 'No se encontraron pedidos para procesar.';
                    break;
                    case 1:
                        msg = 'Se proceso 1 pedido.';
                    break;
                    default:
                        msg = 'Se procesaron ' + data.pedidos + ' pedidos.';
                }
                showMessage('success', msg, true);
            
                if(data.errores > 0){
                    switch(data.pedidos) {
                        case 1:
                            msg = 'Se encontro 1 error en los pedidos procesados.';
                        break;
                        default:
                            msg = 'Se encontraron ' + data.errores + ' errores en los pedidos procesados.';
                    }
                    showMessage('error', msg, false);
                }

                $.pjax.reload({container:'#pedidos-grid'});
                l.stop();
             },"json ");
        });
    });
JS;

    $this->registerJs($script, View::POS_END);
?>
