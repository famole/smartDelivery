<?php
use kartik\tabs\TabsX;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
$this->title = 'Smart Delivery';
?>

<?php
    $items = [
        [
            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Entregas',
            'content'=>$hojaRuta,
            'active'=>true
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-road"></i> Hoja Ruta',
            'content'=>$hojaRuta,
            'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/hoja-ruta'])]
        ],
    ];
    
    // Ajax Tabs Above
//    echo TabsX::widget([
//    'items'=>$items,
//    'position'=>TabsX::POS_ABOVE,
//    'encodeLabels'=>false
//]);
   

?>