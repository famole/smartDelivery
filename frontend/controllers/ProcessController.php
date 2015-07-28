<?php
namespace frontend\controllers;

use frontend\models\Pedido;
use frontend\models\DireccionReplacements;
use frontend\models\Direccion;
use frontend\models\Clientedireccion;
use frontend\models\Entrega;
use frontend\models\EstadosSearch;

use frontend\enum\EnumReplacementType;
use frontend\enum\EnumBaseStatus;
use frontend\enum\EnumProcessError;

use frontend\helper\UtilHelper;

class ProcessController extends SiteController{
    
    public function actionProcessPedidos(){
        $orden = 0;
        $error = 0;
        $pedidosPendientes = Pedido::find()->where(['ped_proc' => 0])->all();
        $replacements = DireccionReplacements::find()->all();
        
        //Recorre Pedidos Pendientes
        foreach ($pedidosPendientes as $pedido){
            if ($this->checknull($pedido)){
                
                $direction = trim(strtolower($pedido->ped_direccion));
                $dir_id = $this->actionDirectionExists($direction);
                $orden += 1;
                $date = date_create($pedido->ped_fechahora);            
                $fecha = date_format($date, 'Y-m-d');


                //No existe la direccion en el sistema
                if($dir_id == 0){

                    $dirToResolve = $direction;

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

                    $dirToNominatim = str_replace(' ', ',', $dirToResolve);
                    //Armo url para consultar a Nominatim

                    if($pedido->ped_dep !== '') $dirToNominatim .= '&state='.urlencode($pedido->ped_dep);    

                    $dirToNominatim .= '&countrycodes=UY';
                    //return $dirToNominatim;
                    $results = UtilHelper::dirToLongLat($dirToNominatim);
                    $lat = $results["lat"];
                    $long = $results["long"];

                    if($results["count"] > 1){
                        //Existe mas de un resultado para la direccion buscada
                        $this->actionCreateEntrega($pedido->ped_id, 0, $fecha, $orden, true, EnumProcessError::manyDir);
                        $error+=1;
                    }elseif($results["count"] == 0){
                        //No se resuelve la direccion
                        $this->actionCreateEntrega($pedido->ped_id, 0, $fecha, $orden, true, EnumProcessError::noDir);
                        $error+=1;
                    }else{
                        //Direccion resuelta, guarda y crea entega
                        $dir_id = $this->actionSetDirectionLatLong($pedido->ped_direccion, $lat, $long, $pedido->cli_id);
                        if($dir_id>0){    
                            $this->actionCreateEntrega($pedido->ped_id, $dir_id, $fecha, $orden, false, '');

                            //Seteo pedido como procesado
                            $this->actionSetPedidoAsProcessed($pedido->ped_id);
                        }

                    }     
                }else{
                    //Existe direccion resuelta, chequear relacion con cliente y crear Entrega
                    if (!$this->actionExistCliDir($pedido->cli_id, $dir_id)){
                        //Crea relacion
                        $this->actionSetCliDir($pedido->cli_id, $dir_id);
                    }
                    //Crear Entrega
                    $this->actionCreateEntrega($pedido->ped_id, $dir_id, $fecha, $orden, false, '');

                    //Seteo pedido como procesado
                    $this->actionSetPedidoAsProcessed($pedido->ped_id);
                }
            }else {
                $error += 1;
            }
       
        }
        return json_encode(array(
            'pedidos' => $orden,
            'errores' => $error
        ));
    }
    
    public function actionSetDirectionLatLong($address, $lat, $long, $cli_id){
        
            $Direccion = new Direccion();
            $Direccion->dir_direccion = $address;
            $Direccion->dir_latstr = $lat;
            $Direccion->dir_longstr = $long;
            $dir = $Direccion->save();
            if($dir > 0){
                //Set Relacion Cliente Direccion
                $result = $this->actionSetCliDir($cli_id, $dir);
                if($result) return $dir;
                return false;
                
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
        $Pedido->ped_ultproc = date("Y-m-d H:i:s");
        $Pedido->ped_proc = true;
        return $Pedido->save();
    }
    
    public function actionExistCliDir($cli, $dir){
        return Clientedireccion::findOne(['cli_id' => $cli, 'dir_id' => $dir]) !== null;
    }
    
    public function actionCreateEntrega($ped_id, $dir_id, $fecha, $orden, $pdef, $errtype){
        
        $Entrega = new Entrega();
        $Entrega->ent_orden = $orden;
        $Entrega->ped_id = $ped_id;
        $Entrega->dir_id = $dir_id;
        $Entrega->ent_fecha = $fecha;
        $Entrega->ent_pendefinir = $pdef;
        $Entrega->est_id = $this->actionGetFirstEstado();
        $Entrega->ent_errorDesc = $errtype;

        return $Entrega->save();
    }
    
    public function actionGetFirstEstado(){
        return EstadosSearch::getIdByName(EnumBaseStatus::PendArmar);    
    }
    
    private function checknull($pedido){
        if($pedido->ped_direccion == ''){
            //Set Pedido Error dir null
            return false;
        }
        
        if($pedido->ped_fechahora = ''){
            //Set Pedido Error fecha hora null
            return false;
        }
        return true;
    }
}
