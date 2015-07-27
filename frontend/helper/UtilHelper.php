<?php
namespace frontend\helper;

use frontend\controllers\ParametrosController;
use frontend\enum\EnumSideNav;

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
     * @param String $direction
     * 
     */
    public static function dirToLongLat($direction, $lat, $long, $results){
        header('Content-Type', 'application/json');
        $url = ParametrosController::getParamText('NOMINATIMURL');
       
        $url .= $direction . '&format=json&polygon=0&addressdetails=0';
    
        $json = UtilHelper::curlPostRequest($url, 'POST');
        
        $jsonDecoded = json_decode($json, true);
        $results = count($jsonDecoded);
        $lat = $jsonDecoded[0]['lat'];
        $long = $jsonDecoded[0]['long'];
        
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
    
    public static function createItemsForSideNav($list, $type){
       
        switch ($type) {
            case EnumSideNav::Entrega:
                $items = array();
                $counter = 0;
                foreach($list as $entrega){
                    $counter++;
                    $item = array(
                           "key" => $counter,
                           "content" => $entrega['direccion'],
//                           "icon" => "map-marker",
//                           "options" => ["id" => $vehiculo->ve_id],
                        );
                    array_push($items, $item);
                }
                break;
            
            case EnumSideNav::Vehiculo:
                 $items = array(array(
                   "url" => "#",
                   "label" => "Todos",
                   "icon" => "map-marker",
                   "options" => ["id" => 'Todos'],
                ));
                foreach($list as $vehiculo){
                    $item = array(
                           "url" => "#",
                           "label" => $vehiculo->ve_matricula . "(" . $vehiculo->ve_movil . ")",
                           "icon" => "map-marker",
                           "options" => ["id" => $vehiculo->ve_id],
                        );
                    array_push($items, $item);
                }
                break;
        }
        
        return $items;
    }
    
    
    
}
