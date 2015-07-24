<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\base\Exception;
use Yii;


use frontend\models\Pedido;
use frontend\models\DireccionReplacements;
use frontend\models\Direccion;
use frontend\models\Clientedireccion;
use frontend\models\Entrega;

use frontend\enum\EnumReplacementType;
use frontend\helper\UtilHelper;

class ProcessController extends SiteController{
    
    public function actionProcessPedidos(){
        $pedidosPendientes = Pedido::find()->where(['ped_proc' => 0])->all();
        $replacements = DireccionReplacements::find()->all();
        
        //Recorre Pedidos Pendientes
        foreach ($pedidosPendientes as $pedido){
            $direction = trim(strtolower($pedido->ped_direccion));
            $dir_id = $this->actionDirectionExists($direction);
            
            //Seteo pedido como procesado
            $this->actionSetPedidoAsProcessed($pedido->ped_id);
            
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
                
                $dirToNominatim = str_replace(' ', ',', $dirToResolve);
                //Armo url para consultar a Nominatim
                //$dirToNominatim = urlencode($dirToResolve);
                if($pedido->ped_dep !== '') $dirToNominatim .= '&state='.urlencode($pedido->ped_dep);    
               
                $dirToNominatim .= '&countrycodes=UY';
                //return $dirToNominatim;
                $results = UtilHelper::dirToLongLat($dirToNominatim);
                $lat = $results["lat"];
                $long = $results["long"];
                
                if($results["count"] > 1){
                    //Existe mas de un resultado para la direccion buscada
                    
                    return 'muchas direcciones';
                }elseif($results["count"] == 0){
                    //No se resuelve la direccion
                    
                }else{
                    //Direccion resuelta, guarda y crea entega
                    return $this->actionSetDirectionLatLong($pedido->ped_direccion, $lat, $long, $pedido->cli_id);                    
                }
                  
            }else{
                //Existe direccion resuelta, chequear relacion con cliente y crear Entrega
                if (!$this->actionExistCliDir($pedido->cli_id, $dir_id)){
                    //Crea relacion
                    $this->actionSetCliDir($pedido->cli_id, $dir_id);
                }
                //Crear Entrega
                //Tengo que definir como enviarle la fecha de entrega ya que el origen es un datetime.
                //$this->actionCreateEntrega($pedido->ped_id, $dir_id, $pedido->ped_, $orden, $pdef)
            }
       
        }
        return true;
    }
    
    public function actionSetDirectionLatLong($address, $lat, $long, $cli_id){
        
            $Direccion = new Direccion();
            $Direccion->dir_direccion = $address;
            $Direccion->dir_latstr = $lat;
            $Direccion->dir_longstr = $long;
            $dir = $Direccion->save();
            if($dir > 0){
                //Set Relacion Cliente Direccion
                return $this->actionSetCliDir($cli_id, $dir);
                
            }else{
                return false;
            }
        
    }
    
    public function actionDirectionExists($directionparm){ 
        $direccion = Direccion::find()->where(['dir_direccion'=>$directionparm])->one();
        if($direccion->dir_latstr != ''){
            $dir_id = $direccion->dir_id;
        }
        return $dir_id;
    }
    
    public function actionSetCliDir($cli_id, $dir_id){
        $CliDir = new Clientedireccion();
        $CliDir->cli_id = $cli_id;
        $CliDir->dir_id = $dir_id;
        return $CliDir->save();
    }
    
    public function actionSetPedidoAsProcessed($ped_id){
        $Pedido = Pedido::findOne($ped_id);
        //$Pedido->ped_ultproc = time();
        $Pedido->ped_proc = 1;
        return $Pedido->save();
    }
    
    public function actionExistCliDir($cli, $dir){
        return Clientedireccion::findOne(['cli_id' => $cli, 'dir_id' => $dir]) !== null;
    }
    
    public function actionCreateEntrega($ped_id, $dir_id, $fecha, $orden, $pdef){
        //TODO: Tenemos que resolver como obtener el estado inicial.
        
        $Entrega = new Entrega();
        $Entrega->ent_orden = $orden;
        $Entrega->ped_id = $ped_id;
        $Entrega->dir_id = $dir_id;
        $Entrega->ent_fecha = $fecha;
        $Entrega->ent_pendefinir = $pdef;
        //Estado???
        $Entrega->est_id = 30;
        //
        return $Entrega->save();
    }
}
