<?php

namespace frontend\controllers;

use Yii;
use frontend\models\numeradores;
use frontend\models\NumeradoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NumeradoresController implements the CRUD actions for numeradores model.
 */
class NumeradoresController //extends Controller
{  
    private $numId;
    function __construct($id) {
        $this->numId = $id;
    }   
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
     * Lists all numeradores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NumeradoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single numeradores model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new numeradores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new numeradores();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->num_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing numeradores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->num_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing numeradores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the numeradores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return numeradores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = numeradores::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La pagina solicitada no existe.');
        }
    }
    
    public function getNumerador(){
        $record = Numeradores::findOne($this->numId);
        if ($record !== null) {
        // Retorno numerador y le sumo uno
           $numerador = $record->num_num;
           $record->num_num += 1;
           $record->save();
        } else {
           //Creo nuevo numerador y retorno numero
           $numerador = 1;
           $record = new \frontend\models\Numeradores();
           $record->num_id = $this->numId;
           $record->num_num = $numerador + 1;
           $record->save();   
        }
        return $numerador;
    }
}
