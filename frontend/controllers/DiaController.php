<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\zona;
use frontend\models\Entrega;
use frontend\models\Direccion;
use frontend\models\Estados;
use frontend\helper\UtilHelper;
use frontend\enum\EnumSideNav;
use frontend\controllers\ProcessController;
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
        
         $entregasJson = json_encode($items);
        
         $SorteableItems = UtilHelper::createItemsForSideNav($items, EnumSideNav::Entrega);
         
        // ProcessController::actionPointInZone();
        return $this->render('dia',['zonasJson'=>$zonasJson,'entregasJson'=>$entregasJson,'SorteableItems'=>$SorteableItems]);
        
    }
    
    public function actionCreateDiaReparto($parms){
        $Entrega = new Entrega();
        $test = 'Anda el ajax';
        
        $zpoints = json_decode($parms);
        //$ent = $zpoints[0]->z_id;
        
        $logfile = fopen('test.txt', 'w');
        fwrite($logfile, "\nPedido - Direction> ");//.$ent);// . $zpoints[0]->ent_id);
        fclose($logfile);
        
     //   $Entrega->updateEntregaZona($zpoints);
       // Yii::error($decode);
        echo Json::encode($test);
        
        
        
    }
    
    
}
