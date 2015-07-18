<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\zona;
use frontend\models\Entrega;
use frontend\models\Direccion;


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
        ->select('z_wkt')
        ->where('z_id > :nullId',[':nullId' => $nullId])
        ->orderBy('z_id')
        ->all();

        for ($index = 0; $index < count($rows); ++$index) {
            $zonas[$index] = $rows[$index]->z_wkt;

        }
        $zonasJson = json_encode($zonas); 
        
        $entregas = Entrega::find()
        ->select('*')
        ->where('ent_fecha = :date',[':date' => $date])
        ->orderBy('ent_id')
        ->all();
        
//        foreach($entregas as $entrega){
//            
//            $direccion = Direccion::find()            
//            ->where('dir_id = :dir',[':dir' => $entrega.dir_id])           
//            ->one();
//            
//            $item = array();
//            
//        }
        
        return $this->render('dia',['zonasJson'=>$zonasJson,'entregas'=>$entregas,]);
        
    }
    
    
}
