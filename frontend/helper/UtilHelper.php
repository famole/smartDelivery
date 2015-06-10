<?php
namespace frontend\helper;

use frontend\controllers\ParametrosController;
use Yii;
/**
* Clase UtilHelper, en esta clase se definiran metodos utiles a utilizar en todo el sistema.
*
* @author Fabian Molina
*/
class UtilHelper{
    
    static function dirToLongLat($direccion){
        header('Content-Type', 'application/json');
        $url = ParametrosController::getParamText('NOMINATIMURL');
        Yii::error($url);
       
        $url .= $direccion . '&format=json&polygon=0&addressdetails=0';
        Yii::error($url);
        $json = file_get_contents($url);
        $obj = json_decode($json);
        
        Yii::error($json);
        Yii::error($obj);
        
    }
    
}
