<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Entrega;
use frontend\models\EntregaSearch;
use frontend\models\Pedido;
use frontend\models\Direccion;
use frontend\models\Clientedireccion;
use frontend\controllers\ParametrosController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\helper\UtilHelper;
use yii\helpers\Json;


/**
 * EntregaController implements the CRUD actions for Entrega model.
 */
class EntregaController extends Controller
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
     * Lists all Entrega models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntregaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entrega model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Entrega model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entrega();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ent_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Entrega model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ent_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Entrega model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Entrega model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entrega the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entrega::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetErrors($id){
        if (($entrega = Entrega::findOne($id)) !== null) {
            if (($pedido = Pedido::findOne($entrega->ped_id)) !== null) {
            
                $ditToNominatim = UtilHelper::setDirToNominatim($pedido->ped_direccion, $pedido->ped_dep);
                $results = UtilHelper::dirToLongLat($ditToNominatim);
                return Json::encode($results);
            }
            
        }
        return null;
    }
    
    public function actionSetAddress($id){
        if (($entrega = Entrega::findOne($id)) !== null) {
            if (($pedido = Pedido::findOne($entrega->ped_id)) !== null) {
            
                $ditToNominatim = UtilHelper::setDirToNominatim($pedido->ped_direccion, $pedido->ped_dep);
                $results = UtilHelper::dirToLongLat($ditToNominatim);
                $items = UtilHelper::createItemsForSideNav($results, 'DIR');

            }
            
        }
        $lat = ParametrosController::getParamText('DEFLAT');
        $lon = ParametrosController::getParamText('DEFLON');
        
        
        return $this->render('selectaddress', ['address'=>Json::encode($results), 'items'=>$items, 'deflat'=>$lat, 'deflon'=>$lon, 'id'=>$id]);
    }
    
    public function actionSaveLatLon($id, $lat, $lon){
        if (($entrega = Entrega::findOne($id)) !== null) {
            if (($pedido = Pedido::findOne($entrega->ped_id)) !== null) {
                $direccion = new Direccion();
                $direccion->dir_direccion = $pedido->ped_direccion;
                $direccion->dir_lat = $lat;
                $direccion->dir_lon = $lon;
                $dirId = $direccion->save();
                if($dirId > 0){
                    $clidir = new Clientedireccion();
                    $clidir->cli_id = $pedido->cli_id;
                    $clidir->dir_id = $dirId;
                    $rows = $clidir->save();
                    
                    $entrega->ent_errorDesc = '';
                    $entrega->ent_pendefinir = 0;
                    if ($entrega->save()){
                        //render
                        return $this->redirect(['index']);
                    }else{
                        return 'Error al actualizar los datos de la entrega.';
                    }
                    
                }else{
                    return 'Error al guardar la direccion.';
                }
            }
        }
    }
    
 
}
