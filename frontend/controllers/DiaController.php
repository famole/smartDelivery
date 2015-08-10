<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\zona;
use frontend\models\Entrega;
use frontend\models\Direccion;
use frontend\models\Estados;
use frontend\models\Vehiculo;
use frontend\models\Personal;
use frontend\helper\UtilHelper;
use frontend\enum\EnumSideNav;
use frontend\models\Reparto;
use frontend\models\RepartoEntrega;
use frontend\controllers\ProcessController;
use frontend\enum\EnumBaseStatus;
use frontend\enum\EnumStatusType;
use yii\helpers\Json;

date_default_timezone_set('America/Argentina/Buenos_Aires');
error_reporting(E_ALL); 
ini_set("display_errors",1);
/**
 * Description of DiaController
 *
 * @author rodri
 */
class DiaController extends Controller{
    //put your code here
    
    
     public function actionDia()
    {
        $date = date("Y-m-d");
        $zonas= array();
        
        $nullId = 0;
        $rows = Zona::find()
        ->select('*')
        ->where('z_id > :nullId',[':nullId' => $nullId])
        ->orderBy('z_id')
        ->all();

        for ($index = 0; $index < count($rows); ++$index) {
            //$zonas[$index] = $rows[$index]->z_wkt;
            $item = array(
                    "wkt" => $rows[$index]->z_wkt,
                    "z_id" => $rows[$index]->z_id,
                    "z_nombre" => $rows[$index]->z_nombre,
                
            );
            
            array_push($zonas, $item);
        }
        $zonasJson = json_encode($zonas); 
        
        $entregas = Entrega::find()
        ->select('*')
        ->where('ent_fecha = :date',[':date' => $date])
        ->orderBy('ent_id')
        ->all();
        
        Yii::error($date);
        Yii::error($entregas);
        Yii::error(json_encode($entregas));
        $items = (array) null;
        foreach($entregas as $entrega){
            
            $direccion = Direccion::find()           
            ->where('dir_id = :dir',[':dir' => $entrega->dir_id])           
            ->one();
            
            $estado = Estados::find()
            ->where('est_id = :est',[':est' => $entrega->est_id])           
            ->one(); 
            Yii::error($estado);    
            $item = array(
                    "entrega" => $entrega->ent_id,
                    "direccion" => $direccion->dir_direccion,
                    "estado" => $estado->est_nom,
                    "lat" => $direccion->dir_lat,
                    "lon" => $direccion->dir_lon,
                
            );
            
            array_push($items, $item);
        }
        
        //Personal disponible para el dia de hoy
        
        
         $entregasJson = json_encode($items);
        
         $SortableItems = UtilHelper::createItemsForSideNav($items, EnumSideNav::Entrega);
         
         //Vehiculos disponibles para el dia de hoy
         $vehiculos = Vehiculo::find()
        ->select('*')
        //->where('ve_estado ='.Vehiculo::ACTIVE)
        ->all();
         
         $vehiculosJson =  JSON::encode($vehiculos);
         
         $personal = new Personal();
         $listaPersonal = $personal->getAvailablePersonalByDate($date);
         $personalJson = JSON::encode($listaPersonal);
         
        // ProcessController::actionPointInZone();
        return $this->render('dia',['zonasJson'=>$zonasJson,'entregasJson'=>$entregasJson,'SortableItems'=>$SortableItems,'vehiculosJson'=>$vehiculosJson,'personalJson'=>$personalJson]);
        
    }
    
    public function actionCreateDiaReparto($parms,$veId){
        $zpoints = json_decode($parms);
        $this->createEntrega($zpoints);
        $repartoId = $this->createReparto($veId);
        $this->createRepartoEntrega($zpoints,$repartoId);

        $test = 'Anda el ajax';
        
    
        
        
       // Yii::error($decode);
        echo Json::encode($test);
        
        
        
    }
    
    private function createEntrega($zpoints){
        $Entrega = new Entrega();
        
        $Entrega->updateEntregaZona($zpoints);
        
    }
    
    private function createReparto($veId){
        $reparto = new Reparto();
        $vehiculoId = JSON::decode($veId);
        $reparto->ve_id = $vehiculoId;
        $estado = Estados::find()->where(['est_nom' => EnumBaseStatus::Preparado,'est_type' => EnumStatusType::System])->one(); 
        $logfile = fopen('test.txt', 'w');
        fwrite($logfile, "\EstadoID> ".$veId);//.$zpoints);// . $zpoints[0]->ent_id);
        fclose($logfile);
        $reparto->est_id = $estado->est_id;
        $repartoId = $reparto->save();
        
        return $repartoId;
        
    }
    
    private function createRepartoEntrega($zpoints,$repartoId){
        foreach($zpoints as $puntos){
            $repartoEntrega = new RepartoEntrega();
            $repartoEntrega->ent_id = $puntos->ent_id;
            $repartoEntrega->rep_id = $repartoId;
            $repartoEntrega->save();
            
        }
        
    }
    
}
