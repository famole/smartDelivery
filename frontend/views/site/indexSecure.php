<?php
use kartik\tabs\TabsX;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
$this->title = 'Smart Delivery';
?>
<div id="alert"></div>
<button type="button" id="process" class="btn btn-default">Procesar Pedidos</button>
<?php
//    $items = [
//        [
//            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Entregas',
//            'content'=>$hojaRuta,
//            'active'=>true
//        ],
//        [
//            'label'=>'<i class="glyphicon glyphicon-road"></i> Hoja Ruta',
//            'content'=>$hojaRuta,
//            'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/hoja-ruta'])]
//        ],
//    ];
    
    // Ajax Tabs Above
//    echo TabsX::widget([
//    'items'=>$items,
//    'position'=>TabsX::POS_ABOVE,
//    'encodeLabels'=>false
//]);
   
$script=<<<JS
        $('#process').click(function(e) {
             //ajax metodo que arma el menu en la busqueda

             
             $.get('index.php?r=process/process-pedidos', function(data){  
                var msg = '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Se proceso(aron) '+ data.pedidos + ' pedido(s) y se encontro ' + data.errores +' error(es).</div>';
                $('#alert').append(msg);
             },"json ");
        });
JS;

$this->registerJs($script);
?>
