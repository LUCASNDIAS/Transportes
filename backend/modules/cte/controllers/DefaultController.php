<?php

namespace backend\modules\cte\controllers;

use Yii;
use backend\modules\cte\models\Cte;
use backend\modules\cte\models\CteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\clientes\models\Clientes;
use yii\filters\AccessControl;
use backend\modules\cte\models\CteDocumentos as Documentos;
use yii\base\Model;
use backend\modules\veiculos\models\Veiculos;
use backend\modules\cte\models\CteVeiculo;
use backend\models\Funcionarios;
use backend\modules\cte\models\CteMotorista;

/**
 * DefaultController implements the CRUD actions for Cte model.
 */
class DefaultController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['bloqueado'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['acessoBasico'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cte models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new CteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',
                [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cte model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view',
                [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model            = new Cte();
        $modelsDocumentos = [new Documentos];
        $modelVeiculos = new Veiculos();
        $modelCteVeiculo = new CteVeiculo();
        $modelFuncionarios = new Funcionarios();
        $modelCteMotorista = new CteMotorista();

        $autocomplete = new Clientes;
        $data         = $autocomplete->autoComplete();

        $veiculos = $modelVeiculos->getVeiculos();
        $veiculos = \yii\helpers\ArrayHelper::map($veiculos, 'placa', 'modelo');

        $motoristas = $modelFuncionarios->getMotorista();
        $motoristas = \yii\helpers\ArrayHelper::map($motoristas, 'id', 'nome');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $modelsDocumentos = Model::createMultiple(Documentos::classname());
            Model::loadMultiple($modelsDocumentos, Yii::$app->request->post());

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create',
                    [
                    'model' => $model,
                    'modelCteVeiculo' => $modelCteVeiculo,
                    'modelCteMotorista' => $modelCteMotorista,
                    'data' => $data,
                    'modelsDocumentos' => (empty($modelsDocumentos)) ? [new Documentos]
                        : $modelsDocumentos,
                    'veiculos' => $veiculos,
                    'motoristas' => $motoristas,
            ]);
        }
    }

    /**
     * Updates an existing Cte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update',
                    [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cte model.
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
     * Finds the Cte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cte::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}