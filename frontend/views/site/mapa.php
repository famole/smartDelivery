<?php
use kartik\sidenav\SideNav;
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>
        <script type="text/javascript" src="js/func.js"></script>
        
        <script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>

        <script type="text/javascript" src="js/OpenLayers_base.js"></script>


        <script type="text/javascript" src="js/OpenLayers_features.js"></script>
        
        <style type="text/css">
        .smallmap {
        width: 700px;
        height: 150px;
        }
        .scrollable-menu {
            height: auto;
            max-height: 200px;
            overflow-x: hidden;
        }
        </style>
    </head>
    
    <body onload="iniciar();iniciarDrawFeacture();">
 
           <div class="col-sm-3">
    
    <?php
 echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'encodeLabels' => false,
    'heading' => $heading,
    'items' => [
        // Important: you need to specify url as 'controller/action',
        // not just as 'controller' even if default action is used.
        ['label' => 'Home', 'icon' => 'home', 'url' => '#', 'active' => ($item == 'home')],
        // 'Products' menu item will be selected as long as the route is 'product/index'
        ['label' => 'Books', 'icon' => 'book', 'items' => [
            ['label' => '<span class="pull-right badge">10</span> New Arrivals', 'url' => '#', 'active' => ($item == 'new-arrivals')],
            ['label' => '<span class="pull-right badge">5</span> Most Popular', 'url' => '#', 'active' => ($item == 'most-popular')],
            ['label' => 'Read Online', 'icon' => 'cloud', 'items' => [
                ['label' => 'Online 1', 'url' => '#', 'active' => ($item == 'online-1')],
                ['label' => 'Online 2', 'url' => '#', 'active' => ($item == 'online-2')]
            ]],
        ]],
        ['label' => '<span class="pull-right badge">3</span> Categories', 'icon' => 'tags', 'items' => [
            ['label' => 'Fiction', 'url' => '#', 'active' => ($item == 'fiction')],
            ['label' => 'Historical', 'url' => '#', 'active' => ($item == 'historical')],
            ['label' => '<span class="pull-right badge">2</span> Announcements', 'icon' => 'bullhorn', 'items' => [
                ['label' => 'Event 1', 'url' => '#', 'active' => ($item == 'event-1')],
                ['label' => 'Event 2', 'url' => '#', 'active' => ($item == 'event-2')]
            ]],
        ]],
        ['label' => 'Profile', 'icon' => 'user', 'url' => '#', 'active' => ($item == 'profile')],
    ],
]);        
    ?>
</div>
         
        <div class="col-sm-9">
          <div class="border">
            
            <div class="slider">
              <ul>
                <li>
                  <div class="item">
                    <div id="mapa" class="smallmap">

                    </div>

                          </div>
                </li>

              </ul>
            </div>
           <div id="main">
              <div id="content" class="left">
                <div class="highlight">
                  
                <table width="80%">
                        <tr>
                                <td align="center">
                                <input type="submit" name="crearFeature" id="crearFeature" value="Crear Zona" onclick="activarDrawFeacture()" /> 
                                </td>
                        <td align="center">
                                <input type="submit" name="editarFeature" id="editarFeature" value="Editar Zona" onclick="activarModifyFeacture()" />
                        </td>
                        <td align="center">
                                <input type="submit" name="mostrarFeature" id="mostrarFeature" value="Mostrar" onclick="mostrarArray()" /> 
                                </td>
                                </tr>
                </table>


                <p align="center"><strong>Coordenadas Zona</strong></p>
                <div align="center">
                  <textarea name="coordenadasZona" cols="80" rows="10" id="coordenadasZona"></textarea>
                  </input>                
                </div>  
                  </div>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="shadow-l"></div>
            <div class="shadow-r"></div>
            <div class="shadow-b"></div>
          </div>
         
        </div>
        </div>
</body>
</html>
