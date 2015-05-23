<?php

namespace frontend\controllers;

use Yii;
use frontend\models\pedido;
use frontend\models\PedidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PedidoController implements the CRUD actions for pedido model.
 */
class PedidoController extends Controller
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
     * Lists all pedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PedidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single pedido model.
     * @param integer $ped_id
     * @param integer $cli_id
     * @return mixed
     */
    public function actionView($ped_id, $cli_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($ped_id, $cli_id),
        ]);
    }

    /**
     * Creates a new pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new pedido();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ped_id' => $model->ped_id, 'cli_id' => $model->cli_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ped_id
     * @param integer $cli_id
     * @return mixed
     */
    public function actionUpdate($ped_id, $cli_id)
    {
        $model = $this->findModel($ped_id, $cli_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ped_id' => $model->ped_id, 'cli_id' => $model->cli_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ped_id
     * @param integer $cli_id
     * @return mixed
     */
    public function actionDelete($ped_id, $cli_id)
    {
        $this->findModel($ped_id, $cli_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ped_id
     * @param integer $cli_id
     * @return pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ped_id, $cli_id)
    {
        if (($model = pedido::findOne(['ped_id' => $ped_id, 'cli_id' => $cli_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
