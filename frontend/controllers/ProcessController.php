<?php
namespace frontend\controllers;

use yii\web\Controller;

use frontend\models\Pedido;
use frontend\models\DireccionReplacements;
use frontend\models\Direccion;

use frontend\enum\EnumReplacementType;
use frontend\helper\UtilHelper;

class ProcessController extends Controller{
    
    public function actionProcessPedidos(){
        $pedidosPendientes = Pedido::find()->where(['ped_proc' => false])->all();
        $replacements = DireccionReplacements::find()->all();
        
        //Recorre Pedidos Pendientes
        foreach ($pedidosPendientes as $pedido){
            $direction = trim(strtolower($pedido->ped_direccion));
            $dir_id = $this->actionDirectionExists($direction);
            
            //No existe la direccion en el sistema
            if($dir_id == 0){
                $dirToResolve = $direction;
                
                //Recorro replacements y sustituyo.
                foreach ($replacements as $replacement){
                    switch($replacement->dr_type){
                        case EnumReplacementType::replacement:
                            $dirToResolve = str_replace($replacement->dr_str, $replacement->dr_value, $direction);                                                
                        case EnumReplacementType::ignore:
                            $tmpDir = explode($replacement->dr_str, $direction);
                            $dirToResolve = $tmpDir[0];
                        case EnumReplacementType::regEx:
                            $dirToResolve = preg_replace($replacement->dr_str, $replacement->dr_value, $direction);
                    }    
                }
                
                //Armo url para consultar a Nominatim
                $dirToNominatim = urlencode($dirToResolve);
                if($pedido->ped_dep != '') $dirToNominatim .= '&state='.urlencode($pedido->ped_dep);    
               
                $dirToNominatim .= '&countrycodes=UY';
                UtilHelper::dirToLongLat($dirToNominatim, $lat, $long, $results);

                if($results > 1){
                    //Existe mas de un resultado para la direccion buscada
                }elseif($results == 0){
                    //No se resuelve la direccion
                }else{
                    //Direccion resuelta, guardar
                    $this->actionSetDirectionLatLong($pedido->ped_direccion, $lat, $long);
                }
                            
                            
                  
            }else{
                //Existe direccion resuelta, crear Entrega
            }
       
        }
    }
    
    public function actionSetDirectionLatLong($address, $lat, $long){
        $Direccion = new Direccion();
        $Direccion->dir_direccion = $address;
        $Direccion->dir_latstr = $lat;
        $Direccion->dir_longstr = $long;
        $Direccion->save();
        
    }
    
    public function actionDirectionExists($direction){ 
        $result = Direccion::find()->where(['dir_direccion'=>$direction])->one;
        if($result->dir_latstr != ''){
            $dir_id = $result->dir_id;
        }
        return $dir_id;
    }
}
