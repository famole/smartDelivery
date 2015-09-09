<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Reparto;
use frontend\models\RepartoSearch;
use frontend\models\RepartoEntrega;
use frontend\models\Entrega;
use frontend\models\Direccion;
use frontend\models\Estados;
use frontend\models\Vehiculo;
use frontend\models\RepartoPersonal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use frontend\enum\EnumBaseStatus;
use frontend\models\EstadosSearch;


date_default_timezone_set('America/Argentina/Buenos_Aires');
/**
 * RepartoController implements the CRUD actions for Reparto model.
 */
class RepartoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reparto models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $vehMat = null;
        $this->checkLogin();
        $searchModel = new RepartoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $date = date("Y-m-d");
        $entregas = Entrega::find()
        ->select('*')
        ->where(['ent_fecha' =>$date])
        ->all();
        
        $items = (array) null;
        foreach($entregas as $entrega){
            
            $direccion = Direccion::find()           
            ->where('dir_id = :dir',[':dir' => $entrega->dir_id])           
            ->one();
            
            $estado = Estados::find()
            ->where('est_id = :est',[':est' => $entrega->est_id])           
            ->one(); 
            if($estado->est_nom == 'Pendiente-Reparto'){
                $repEntrega = RepartoEntrega::find()
                ->select('*')
                ->where(['ent_id' =>$entrega->ent_id])
                ->one();
                
                if($repEntrega != null){
                    $repId = $repEntrega->rep_id;
                    $rep = Reparto::find()
                    ->select('*')
                    ->where(['rep_id' =>$repId])
                    ->one();
                   
                    $vehId = $rep->ve_id;
                    $vehiculo = Vehiculo::find()
                    ->select('*')
                    ->where(['ve_id' =>$vehId])
                    ->one();
                    
                    $vehMat = $vehiculo->ve_matricula;                   
                    
                }
                
            }
            Yii::error($estado);
            $dir =NULL;
            $lat = NULL;
            $lon = NULL;
            if($direccion != null){
                $dir = $direccion->dir_direccion;
                $lat = $direccion->dir_lat;
               $lon=  $direccion->dir_lon;
            }
            $item = array(
                    "entrega" => $entrega->ent_id,
                    "direccion" => $dir,
                    
                    "lat" => $lat,
                    "lon" => $lon,
                    "estado" => $estado->est_nom,
                    "vehiculo"=> $vehMat,
                
            );
            
            array_push($items, $item);
        }
        
        //Personal disponible para el dia de hoy
        
        
         $entregasJson = json_encode($items);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'entregasJson' => $entregasJson,
        ]);

    }

    /**
     * Displays a single Reparto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->checkLogin();
        $repartoEntrega = RepartoEntrega::find()->where(['rep_id' => $id])->all();
        
        $i = 0;
        foreach($repartoEntrega as $entrega){
            $listaEntregas[$i] = $entrega->ent_id;
            $i = $i + 1;
        }
        
        $query = Entrega::find()->where([
            'ent_id' => $listaEntregas 
        ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);
              
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'entregaDataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reparto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkLogin();
        $model = new Reparto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rep_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Reparto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->checkLogin();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rep_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Reparto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->checkLogin();
        
        
        $reparto = $this->findModel($id);
        $repartoEntrega = RepartoEntrega::find()->where(['rep_id' => $id])->all();
        
        if(RepartoPersonal::deleteAll('rep_id='.$id) > 0){
        
            foreach($repartoEntrega as $repEntrega){
                $entrega = Entrega::findOne($repEntrega->ent_id);
                $entrega->est_id = EstadosSearch::getIdByName(EnumBaseStatus::PendArmar);
                $entrega->save();
            }
            
            RepartoEntrega::deleteAll(['rep_id' => $id]);
        }
        
        $reparto->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Reparto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reparto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reparto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    private function checkLogin(){
        
        if (Yii::$app->getUser()->isGuest &&
            Yii::$app->getRequest()->url !== Url::to(Yii::$app->getUser()->loginUrl)
        ) {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl);
        }
    
    }
}
