<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

  <div class="col-sm-3">
    
    <?php
    foreach($vehiculos as $vehiculo):
        Yii::error($vehiculo->ve_matricula);
    endforeach;
    
    echo SideNav::widget([
       'type' => SideNav::TYPE_DEFAULT,
       'encodeLabels' => false,
       'heading' => "Vehiculos",
       'items' => [
           
            ['label' => 'Books', 'icon' => 'book', 'items' => [
                ['label' => '<span class="pull-right badge">10</span> New Arrivals', 'url' => '#', 'active' => ($item == 'new-arrivals')],
                ['label' => '<span class="pull-right badge">5</span> Most Popular', 'url' => '#', 'active' => ($item == 'most-popular')],
                ['label' => 'Read Online', 'icon' => 'cloud', 'items' => [
                    ['label' => 'Online 1', 'url' => '#', 'active' => ($item == 'online-1')],
                    ['label' => 'Online 2', 'url' => '#', 'active' => ($item == 'online-2')]
                ]],
            ]],
           
       ],
   ]);        
?>
