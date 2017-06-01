<?php

namespace backend\controllers;

use Yii;
use backend\models\Clientes; 
use backend\models\ClientesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use backend\models\Tabelas;
use backend\models\ClientesContatos;
use yii\helpers\ArrayHelper;
use backend\base\Model;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        // Nome das Tabelas para Visualização
        // Verifica se há tabelas no modelo
        if ($model->tabelas != '') {

            // Instancia o Modelo de Tabelas
            $nomeTabelas = new Tabelas();

            // Passa o valor das tabelas para array
            $tabelasBD = explode('|', $model->tabelas);

            // Retorna os nomes na variável
            $tabelas = $nomeTabelas->nomeTabelas($tabelasBD);
        } else {

            // Retorna null para Tabelas
            $tabelas = null;
        }

        return $this->render('view', [
                    'model' => $model,
                    'nomeTabelas' => $tabelas,
        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Clientes;
        $modelsContatos = [new ClientesContatos];

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            $modelsContatos = Model::createMultiple(ClientesContatos::classname());
            Model::loadMultiple($modelsContatos, Yii::$app->request->post());

            if (Yii::$app->request->post('salvar') !== null) {
                if ($model->validate() && Model::validateMultiple($modelsContatos)) {
                    if ($model->save()) {
                        foreach ($modelsContatos as $modelContato) {
                            $modelContato->clientes_id = $model->id;
                            $modelContato->save(false);
                        }
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                                    ActiveForm::validate($model), ActiveForm::validateMultiple($modelsContatos)
                    );
                }
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validate($model), ActiveForm::validateMultiple($modelsContatos)
                );
            }
        } else {

            $tabelas = new Tabelas();
            $listagem = $tabelas->listarNomes();

            return $this->render('create', [
                        'model' => $model,
                        'modelsContatos' => (empty($modelsContatos)) ? [new ClientesContatos] : $modelsContatos,
                        'tabelas' => $listagem,
            ]);
        }
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->post('salvar') !== null) {
                if ($model->validate()) {
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {

            // Nome das Tabelas para o Auto Complete
            // Verifica se há tabelas no modelo
            if ($model->tabelas != '') {

                // Instancia o Modelo de Tabelas
                $nomeTabelas = new Tabelas();

                // Passa o valor das tabelas para array
                $tabelasBD = explode('|', $model->tabelas);

                // Retorna os nomes na variável
                $tabelas = $nomeTabelas->nomeTabelas($tabelasBD);
            } else {

                // Retorna null para Tabelas
                $tabelas = null;
            }

            $tabelasSource = new Tabelas();
            $listagem = $tabelasSource->listarNomes();

            return $this->render('update', [
                        'model' => $model,
                        'nomeTabelas' => $tabelas,
                        'tabelas' => $listagem,
            ]);
        }
    }

    /**
     * Deletes an existing Clientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
