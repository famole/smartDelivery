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
use frontend\enum\EnumBaseStatus;
use frontend\enum\EnumStatusType;


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
            $estadoPendRep = Estados::find()->where(['est_nom' => EnumBaseStatus::PendienteReparto,'est_type' => EnumStatusType::System])->one();
            foreach($repartoEntrega as $re){
                $entrega = Entrega::find()           
               ->where(['ent_id' => $re->ent_id,'est_id' => $estadoPendRep->est_id])           
               ->one();
                
                if ($entrega != null){
                
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
            }
            $SideNavItems = UtilHelper::createItemsForSideNav($entregas, EnumSideNav::Entrega);
        $entregasJson = JSON::encode($entregas);
            
        }
        
        
        return $this->render('camion',['SideNavItems'=>$SideNavItems,'entregasJson'=>$entregasJson,'vehiculoId'=>$vehiculoId,'fecha'=>$fecha,'repartoId'=>$reparto->rep_id]);
        
        
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
    
    
    public function actionSetEstadoEntrega($entregaId,$estado){
        
        switch($estado){
            case 'Entregado':
                $estado = Estados::find()
                ->where(['est_type' => EnumStatusType::System, 'est_nom' => EnumBaseStatus::Entregado])           
                ->one();
                break;
            case 'Cancelado':
                $estado = Estados::find()
                ->where(['est_type' => EnumStatusType::System, 'est_nom' => EnumBaseStatus::Cancelado])           
                ->one();
                break;
                
        }
        
        $entrega = new Entrega();
       echo  $entrega->UpdateEntregaEstado($entregaId,$estado->est_id);
        
        
    }
    
    public function actionUpdateEstadoReparto($repartoId){
        
        $reparto = new Reparto();
        echo $reparto->SetEstadoReparto($repartoId);
    }
    
    
    
}
