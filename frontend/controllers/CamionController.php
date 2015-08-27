<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Entrega;
use frontend\models\Reparto;
use frontend\models\RepartoEntrega;
use frontend\models\Direccion;
use frontend\models\Estados;
use yii\helpers\Json;
use frontend\helper\UtilHelper;
use frontend\enum\EnumSideNav;


class CamionController extends Controller{
    
    public function actionCamion($vehiculoId,$fecha){
        $SideNavItems = null;
        $entregasJson = null;
        
        $reparto = Reparto::find()
        ->select('*')
        ->where(['ve_id'=>$vehiculoId,'rep_fecha'=>$fecha])
        ->one();
        
        if($reparto != null){
        
            $repartoEntrega= RepartoEntrega::find()
            ->select('*')
            ->where(['rep_id'=>$reparto->rep_id])
            ->orderBy('re_orden')
            ->all();
            
            $entregas = (array) null;

            foreach($repartoEntrega as $re){
                $entrega = Entrega::find()           
               ->where(['ent_id' => $re->ent_id])           
               ->one();
                
                $direccion = Direccion::find()           
                ->where('dir_id = :dir',[':dir' => $entrega->dir_id])           
                ->one();
                
                $estado = Estados::find()
                ->where('est_id = :est',[':est' => $entrega->est_id])           
                ->one(); 
                 
                $item = array(
                        "entrega" => $entrega->ent_id,
                        "direccion" => $direccion->dir_direccion,
                        "estado" => $estado->est_nom,
                        "lat" => $direccion->dir_lat,
                        "lon" => $direccion->dir_lon,

                );
                
               
               array_push($entregas,$item);
            }
            $SideNavItems = UtilHelper::createItemsForSideNav($entregas, EnumSideNav::Entrega);
        $entregasJson = JSON::encode($entregas);
        }
        
        
        return $this->render('camion',['SideNavItems'=>$SideNavItems,'entregasJson'=>$entregasJson]);
        
        
    }
    
    public function actionGetEntrega($idEntrega){
        $entrega = Entrega::find()           
        ->where(['ent_id' => $idEntrega])           
        ->one();
        
        $estado = Estados::find()
        ->where('est_id = :est',[':est' => $entrega->est_id])           
        ->one(); 
        
        $direccion = Direccion::find()           
        ->where('dir_id = :dir',[':dir' => $entrega->dir_id])           
        ->one();
        
         $item = array(
                "entrega" => $entrega->ent_id,
                "direccion" => $direccion->dir_direccion,
                "estado" => $estado->est_nom,
             );
        
        
        
        echo Json::encode($item);
    }
    
    
    
}
