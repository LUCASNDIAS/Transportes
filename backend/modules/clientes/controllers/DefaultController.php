<?php

namespace backend\modules\clientes\controllers;

use Yii;
use backend\base\Model;
use backend\modules\clientes\models\Clientes;
use backend\modules\clientes\models\ClientesSearch;
use backend\modules\clientes\models\ClientesContatos as Contatos;
use backend\modules\clientes\models\TabelasClientes as Tabelas;
use backend\models\Tabelas as Tab;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for Clientes model.
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
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',
                [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
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
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model          = new Clientes;
        $modelsContatos = [new Contatos];
        $modelsTabelas  = [new Tabelas];

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && Yii::$app->request->post('salvar') === null) {
            Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $modelsContatos = Model::createMultiple(Contatos::classname());
            Model::loadMultiple($modelsContatos, Yii::$app->request->post());

            $modelsTabelas = Model::createMultiple(Tabelas::classname());
            Model::loadMultiple($modelsTabelas, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
//            $valid = Model::validateMultiple($modelsContatos) && $valid;
//            $valid = Model::validateMultiple($modelsTabelas) && $valid;
//           
            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        $last_id = \Yii::$app->db->getLastInsertID();

                        foreach ($modelsContatos as $modelContatos) {
                            $modelContatos->clientes_id = $last_id;

                            if (!($flag = $modelContatos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsTabelas as $modelTabelas) {
                            $modelTabelas->cliente_id = $last_id;

                            if (!($flag2 = $modelTabelas->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }


                    if ($flag && $flag2) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {

                    $transaction->rollBack();
                }
            }
        }

        $data = Tab::autoComplete();

        return $this->render('create',
                [
                'model' => $model,
                'modelsContatos' => (empty($modelsContatos)) ? [new Contatos] : $modelsContatos,
                'modelsTabelas' => (empty($modelsTabelas)) ? [new Tabelas] : $modelsTabelas,
                'data' => $data
        ]);
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsContatos = $model->clientesContatos;
        $modelsTabelas = $model->tabelasClientes;

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && Yii::$app->request->post('salvar') === null) {
            Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('salvar') !== null) {

            $oldIDs = ArrayHelper::map($modelsContatos, 'id', 'id');
            $modelsContatos = Model::createMultiple(Contatos::classname(), $modelsContatos);
            Model::loadMultiple($modelsContatos, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsContatos, 'id', 'id')));

            $oldIDstab = ArrayHelper::map($modelsTabelas, 'id', 'id');
            $modelsTabelas = Model::createMultiple(Tabelas::classname(), $modelsTabelas);
            Model::loadMultiple($modelsTabelas, Yii::$app->request->post());
            $deletedIDstab = array_diff($oldIDstab, array_filter(ArrayHelper::map($modelsTabelas, 'id', 'id')));

            // validate all models
            $valid = $model->validate();

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        if (!empty($deletedIDs)) {
                            Contatos::deleteAll(['id' => $deletedIDs]);
                        }

                        if (!empty($deletedIDstab)) {
                            Tabelas::deleteAll(['id' => $deletedIDstab]);
                        }

                        foreach ($modelsContatos as $modelContatos) {
                            $modelContatos->clientes_id = $model->id;
                            if (! ($flag = $modelContatos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsTabelas as $modelTabelas) {
                            $modelTabelas->cliente_id = $model->id;
                            if (! ($flag2 = $modelTabelas->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                    }

                    if ($flag && $flag2) {

                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);

                    }

                } catch (Exception $e) {

                    $transaction->rollBack();

                }
            }
        }

        $data = Tab::autoComplete();

        return $this->render('update',
                [
                'model' => $model,
                'modelsContatos' => (empty($modelsContatos)) ? [new Contatos] : $modelsContatos,
                'modelsTabelas' => (empty($modelsTabelas)) ? [new Tabelas] : $modelsTabelas,
                'data' => $data
        ]);
        
    }

    /**
     * Deletes an existing Clientes model.
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
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}