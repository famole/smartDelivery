<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>OpenLayers - Jamper91</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>
        <script type="text/javascript" src="js/func.js"></script>
        
        <script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>

        <script type="text/javascript" src="js/OpenLayers_base.js"></script>


        <script type="text/javascript" src="js/OpenLayers_features.js"></script>
        
        <style type="text/css">
        .smallmap {
        width: 929px;
        height: 300px;
        }
        </style>
    </head>
    
    <body onload="iniciar();iniciarDrawFeacture();">
        <div class="shell">
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