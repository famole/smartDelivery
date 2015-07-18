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
    
    echo SortableInput::widget([
    'name'=> 'sort_list_1',
    'items' => [
        1 => ['content' => '<i class="glyphicon glyphicon-cog"></i> Item # 1'],
        2 => ['content' => '<i class="glyphicon glyphicon-cog"></i> Item # 2'],
        3 => ['content' => '<i class="glyphicon glyphicon-cog"></i> Item # 3'],
        4 => ['content' => '<i class="glyphicon glyphicon-cog"></i> Item # 4'],
        5 => ['content' => '<i class="glyphicon glyphicon-cog"></i> Item # 5', 'disabled'=>true]
    ],
    'hideInput' => true,
]);

?>