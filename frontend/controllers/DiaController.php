<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\zona;


/**
 * Description of DiaController
 *
 * @author rodri
 */
class DiaController extends Controller{
    //put your code here
    
    
     public function actionDia()
    {
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
        return $this->render('dia',['zonasJson'=>$zonasJson,]);
        
    }
    
    
}
