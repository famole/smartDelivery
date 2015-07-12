<?php
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
$this->title = 'Smart Delivery';
?>

<?php
    $items = [
        [
            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Entregas',
            'content'=>$content1,
            'active'=>true
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-road"></i> Hoja Ruta',
            'content'=>$content2,
            'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/vehiculo/listavehiculos'])]
        ],
    ];
    
    // Ajax Tabs Above
    echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);

?>