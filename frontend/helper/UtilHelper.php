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
    
    /**
     * La siguiente funcion recibe una direccion String y retorna las coordenadas 
     * en latitud y longitud.
     * 
     * @param String $direccion
     * 
     */
    public static function dirToLongLat($direccion){
        header('Content-Type', 'application/json');
        $url = ParametrosController::getParamText('NOMINATIMURL');
        //Yii::error($url);
       
        $url .= $direccion . '&format=json&polygon=0&addressdetails=0';
        //Yii::error($url);
        //$json = file_get_contents($url);
        $json = UtilHelper::curlPostRequest($url, 'POST');
        
        
        Yii::error($json->place_id);
        //Yii::error($obj);
        
    }
    
    /**
     * Funcion creada para consumir webservice REST.
     * 
     * @param String $url /Url de conexion.
     * @param String $http_req /Method Request. 
     * @return String 
     */
    public static function curlPostRequest($url, $http_req){
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_req);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        //post
        $result = curl_exec($ch);

        //cierra conexion
        curl_close($ch);
        
        return $result;
    }
    
}
