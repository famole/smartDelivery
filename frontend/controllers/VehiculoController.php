<?php

namespace frontend\controllers;

use Yii;
use app\models\Vehiculo;
use app\models\VehiculoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * VehiculoController implements the CRUD actions for Vehiculo model.
 */
class VehiculoController extends Controller
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
     * Lists all Vehiculo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehiculoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vehiculo model.
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
     * Creates a new Vehiculo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vehiculo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ve_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Vehiculo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ve_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Vehiculo model.
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
     * Finds the Vehiculo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vehiculo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehiculo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function init(){
        if(Yii::$app->user->isGuest)
        {
            $this->goHome();
        }
    }
    
    public function actionGetVehiculoBy($filter){
        $vehiculos = Vehiculo::find()->where(['like', 've_matricula', $filter.'%',false])->all();
        echo Json::encode($vehiculos);
    }
    
    public function actionListavehiculos(){
        $vehiculos = Vehiculo::find(/*[
            've_estado' => Vehiculo::ACTIVE,
        ]*/)->all();
        
        $items = array(array(
                   "url" => "#",
                   "label" => "Todos",
                   "icon" => "map-marker",
                   "options" => ["id" => 'Todos'],
                ));
        
        foreach($vehiculos as $vehiculo){
            
            $item = array(
                   "url" => "#",
                   "label" => $vehiculo->ve_matricula . "(" . $vehiculo->ve_movil . ")",
                   "icon" => "map-marker",
                   "options" => ["id" => $vehiculo->ve_id],
                );
            array_push($items, $item);
        }
        return $this->render('listavehiculos', ['items'=>$items]);
    }
 
}
