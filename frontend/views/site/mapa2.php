<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mapa</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>
<script type="text/javascript" src="js/func.js"></script>
<script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js">
</script>
<script type="text/javascript" src="js/OpenLayers_base.js"></script>
<script type="text/javascript">
	//Habilito que se muestren mensajes al dar clic en el mapa
	activarMensaje=1;
	
</script>
<style type="text/css">
.smallmap {
width: 929px;
height: 300px;
}
</style>
</head>
<body onload="iniciar()">
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
        <p><strong>Coordenadas</strong>:
<input name="coordenadas" type="text" id="coordenadas" size="50"></input>                </div>
      </div>
      <div class="cl">&nbsp;</div>
    </div>
    <div class="shadow-l"></div>
    <div class="shadow-r"></div>
    <div class="shadow-b"></div>
  </div>
  
</div>
</body>
</html>