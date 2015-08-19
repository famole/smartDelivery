<?php
namespace frontend\helper;

use frontend\controllers\ParametrosController;
use frontend\enum\EnumSideNav;

use frontend\models\DireccionReplacements;

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
    public static function dirToLongLat($direction){
        header('Content-Type', 'application/json');
        $url = ParametrosController::getParamText('NOMINATIMURL');
       
        $url .= $direction . '&format=json&polygon=0&addressdetails=0';
    
        $json = UtilHelper::curlPostRequest($url, 'POST');
        
        $jsonDecoded = json_decode($json, true);
        $results = count($jsonDecoded);
        $result = array();
        for($i=0;$i<$results;$i++){
            $lat = $jsonDecoded[$i]['lat'];
            $long = $jsonDecoded[$i]['lon'];
            $displayName = $jsonDecoded[$i]['display_name'];
            array_push($result, array(
                "lat" => $lat,
                "long" => $long,
                "display_name" => $displayName
            ));
        }
        
        return $result;

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
    public static function createItemsForSortable($list, $type){
        switch ($type) {
            case EnumSideNav::Entrega:
                $items = array();
                
                foreach($list as $entrega){
                    
                    $item = array(
                           "key" => $entrega['entrega'],
                           "content" => $entrega['direccion'],
//                           "icon" => "map-marker",
//                           "options" => ["id" => $vehiculo->ve_id],
                        );
                    array_push($items, $item);
                }
                break;
        }
        return $items;
        
    }
    public static function createItemsForSideNav($list, $type){
       
        switch ($type) {
            case EnumSideNav::Entrega:
                $items = array();
                
                foreach($list as $entrega){
                    
                    $item = array(
                           "url" => "#",
                           "label" => $entrega['direccion'],
                           "icon" => "map-marker",
                           "options" => ["id" => $entrega['entrega']],
                        );
                    array_push($items, $item);
                }
                break;
            case EnumSideNav::Direccion:
                $items = array();
                $lenght = count($list);
                for($i=0; $i<$lenght;$i++){
                    $item = array(
                           "url" => "#",
                           "label" => $list[$i]['display_name'],
                           "icon" => "map-marker",
                           "options" => ["id" => $i],
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
                           "label" => $vehiculo->ve_matricula . " (Movil " . $vehiculo->ve_movil . ")",
                           "icon" => "map-marker",
                           "options" => ["id" => $vehiculo->ve_id],
                        );
                    array_push($items, $item);
                }
                break;
        }
        
        return $items;
    }
    
    public static function setDirToNominatim($dir, $state){
        $replacements = DireccionReplacements::find()->all();
        $dirToResolve = $dir;

        //Recorro replacements y sustituyo.
        foreach ($replacements as $replacement){
            switch($replacement->dr_type){
                case EnumReplacementType::replacement:
                    $dirToResolve = str_replace($replacement->dr_str, $replacement->dr_value, $dirToResolve);                                                
                case EnumReplacementType::ignore:
                    $tmpDir = explode($replacement->dr_str, $dirToResolve);
                    $dirToResolve = $tmpDir[0];
                case EnumReplacementType::regEx:
                    $dirToResolve = preg_replace($replacement->dr_str, $replacement->dr_value, $dirToResolve);
            }    
        }

        $dirToNominatim = str_replace(' ', '+', $dirToResolve);
        //Armo url para consultar a Nominatim


        if($state !== '') $dirToNominatim .= '&state='.urlencode($state);    
        $logfile = fopen('test.txt', 'w');
        $dirToNominatim .= '&countrycodes=UY';
        fwrite($logfile, "\nUTILHELPER - Direction to Nominatim> " . $dirToNominatim);
        return $dirToNominatim;
        
    }
    
    
    
}
