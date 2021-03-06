<?php
namespace frontend\controllers;

use frontend\models\Pedido;
use frontend\models\DireccionReplacements;
use frontend\models\Direccion;
use frontend\models\Clientedireccion;
use frontend\models\Entrega;
use frontend\models\EstadosSearch;
use frontend\models\TurnosEntrega;

use frontend\enum\EnumReplacementType;
use frontend\enum\EnumBaseStatus;
use frontend\enum\EnumProcessError;

use frontend\helper\UtilHelper;

class ProcessController extends SiteController{
    
    public function actionProcessPedidos(){
        $orden = 0;
        $error = 0;
        $pedidos = 0;
        $pedidosPendientes = Pedido::find()->where(['ped_proc' => 0])->all();
        $replacements = DireccionReplacements::find()->all();
        
        $logfile = fopen('test.txt', 'w');
        
        //Recorre Pedidos Pendientes
        foreach ($pedidosPendientes as $pedido){
            $pedidos += 1;
            
            fwrite($logfile, "\nPedido> " . $pedido->ped_id);
            if ($this->checknull($pedido)){
                
                $direction = trim(strtolower($pedido->ped_direccion));
                fwrite($logfile, "\nPedido - Direction> " . $direction);
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

                    $dirToNominatim = str_replace(' ', '+', $dirToResolve);
                    //Armo url para consultar a Nominatim
                    
                    
                    if($pedido->ped_dep !== '') $dirToNominatim .= '&state='.urlencode($pedido->ped_dep);    

                    $dirToNominatim .= '&countrycodes=UY';
                    fwrite($logfile, "\nPedido - Direction to Nominatim> " . $dirToNominatim);
                    //return $dirToNominatim;
                    $results = UtilHelper::dirToLongLat($dirToNominatim);
                    $lat = $results[0]["lat"];
                    $long = $results[0]["long"];
                    $count = count($results);
                    fwrite($logfile, "\nPedido - Count Dir> " . $count);
                    fwrite($logfile, "\nPedido - Result Nominatim> " . $dirToNominatim);
                    if($count > 1){
                        //Existe mas de un resultado para la direccion buscada
                        $this->actionCreateEntrega($pedido->ped_id, 0, $fecha, $orden, 1, $pedido->ped_fechahora, EnumProcessError::manyDir);
                        //Seteo pedido como procesado
                        $this->actionSetPedidoAsProcessed($pedido->ped_id);
                        $error+=1;
                    }elseif($count == 0){
                        //No se resuelve la direccion
                        $this->actionCreateEntrega($pedido->ped_id, 0, $fecha, $orden, 1, $pedido->ped_fechahora, EnumProcessError::noDir);
                        //Seteo pedido como procesado
                        $this->actionSetPedidoAsProcessed($pedido->ped_id);
                        $error+=1;
                        fwrite($logfile, "\nPedido - No fue posible resolver la direccion> " . $dirToNominatim);
                    }else{
                        //Direccion resuelta, guarda y crea entega
                        $dir_id = $this->actionSetDirectionLatLong($pedido->ped_direccion, $lat, $long, $pedido->cli_id);
                        if($dir_id>0){    
                            $this->actionCreateEntrega($pedido->ped_id, $dir_id, $fecha, $orden, 0, $pedido->ped_fechahora, '');

                            //Seteo pedido como procesado
                            $this->actionSetPedidoAsProcessed($pedido->ped_id);
                        }

                    }     
                }else{
                    //Existe direccion resuelta, chequear relacion con cliente y crear Entrega
                    $this->actionExistCliDir($pedido->cli_id, $dir_id);
                    
                    fwrite($logfile, "\nPedido - Existe dir y crea entrega.");
                    //Crear Entrega
                    $this->actionCreateEntrega($pedido->ped_id, $dir_id, $fecha, $orden, 0, $pedido->ped_fechahora, '');

                    //Seteo pedido como procesado
                    $result = $this->actionSetPedidoAsProcessed($pedido->ped_id);
                    fwrite($logfile, "\nPedido - set processed> " . $pedido->ped_id . " - " . $result);
                }
            }else {
                $error += 1;
            }
       
        }
        fclose($logfile);
        return json_encode(array(
            'pedidos' => $pedidos,
            'errores' => $error
        ));
    }
    
    public function actionSetDirectionLatLong($address, $lat, $long, $cli_id){
        
            $Direccion = new Direccion();
            $Direccion->dir_direccion = $address;
            $Direccion->dir_lat = $lat;
            $Direccion->dir_lon = $long;
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
        $dir_id = NULL;
        $direccion = Direccion::find()->where(['dir_direccion'=>$directionparm])->one();
        if($direccion != NULL){
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
        $clienteDireccion = Clientedireccion::findOne($cli);
        if ($clienteDireccion !== null){
            $clienteDireccion->dir_id = $dir;
            $clienteDireccion->save();
        }else{
            //Crea relacion
            $this->actionSetCliDir($cli, $dir);
        }
    }
    
    public function actionCreateEntrega($ped_id, $dir_id, $fecha, $orden, $pdef, $fechaHora, $errtype){
        
        $Entrega = new Entrega();
        $Entrega->ped_id = $ped_id;
        $Entrega->dir_id = $dir_id;
        $Entrega->ent_fecha = $fecha;
        $Entrega->ent_pendefinir = $pdef;
        $Entrega->est_id = $this->actionGetFirstEstado();
        $Entrega->te_id = $this->getTurnoEntrega($fechaHora);
        $Entrega->ent_errorDesc = $errtype;

        return $Entrega->save();
    }
    
    public function actionGetFirstEstado(){
        return EstadosSearch::getIdByName(EnumBaseStatus::PendArmar);    
    }
    
    private function checknull($pedido){
        if($pedido->ped_direccion == NULL){
            //Set Pedido Error dir null
            $pedToSave = Pedido::findOne($pedido->ped_id);
            $pedToSave->ped_error = 1;
            $pedToSave->ped_errordesc = EnumProcessError::dirEmpty;
            $pedToSave->save();
            return false;
        }
        
        if($pedido->ped_fechahora == NULL){
            //Set Pedido Error fecha hora null
            $pedToSave = Pedido::findOne($pedido->ped_id);
            $pedToSave->ped_error = 1;
            $pedToSave->ped_errordesc = EnumProcessError::dateEmpty;
            $pedToSave->save();
            return false;
        }
        return true;
    }
    
    private function getTurnoEntrega($fechaHora){
        $turnosEntrega = TurnosEntrega::find()->all();
        foreach ($turnosEntrega as $turno){
            if($turno->te_horainicio <= $fechaHora && $turno->te_horafin >= $fechaHora){
                return $turno->te_id;
            }
        }
        return 0;
    }
    
    
}
