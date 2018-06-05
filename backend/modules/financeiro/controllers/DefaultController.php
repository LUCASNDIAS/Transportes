<?php

namespace backend\modules\financeiro\controllers;

use Yii;
use backend\modules\financeiro\models\Financeiro;
use backend\modules\financeiro\models\FinanceiroSearch;
use backend\commands\Basicos;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Financeiro model.
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
                'rules' => [
                    [
                        'allow' => false,
                        'matchCallback' => function ($rule, $action) {
                            throw new HttpException(403, 'Usuário bloqueado! Entre em contato para solucionar este erro.');
                        },
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
     * Lists all Financeiro models.
     * @return mixed
     */
    public function actionIndex($t = 'R')
    {
        $searchModel = new FinanceiroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $t);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Financeiro model.
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
     * Creates a new Financeiro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Financeiro();
        $basicos = new Basicos();

        if ($model->load(Yii::$app->request->post())) {

            $model->emissao = $basicos->formataData('db', $model->emissao);
            $model->vencimento = $basicos->formataData('db', $model->vencimento);

            $hoje = date('Y-m-d');

            $model->status = ($hoje <= $model->vencimento) ? 'A VENCER' : 'VENCIDO';

            //return var_dump($model->dtpgto);

            if ($model->dtpgto != '') {
                $model->dtpgto = $basicos->formataData('db', $model->dtpgto);
                $model->status = 'PAGO';
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Financeiro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $basicos = new Basicos();

        if ($model->load(Yii::$app->request->post())) {

            $model->emissao = $basicos->formataData('db', $model->emissao);
            $model->vencimento = $basicos->formataData('db', $model->vencimento);

            $hoje = date('Y-m-d');

            $model->status = ($hoje <= $model->vencimento) ? 'A VENCER' : 'VENCIDO';

            //return var_dump($model->dtpgto);

            if ($model->dtpgto != '') {
                $model->dtpgto = $basicos->formataData('db', $model->dtpgto);
                $model->status = 'PAGO';
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {

            $model->emissao = $basicos->formataData('form', $model->emissao);
            $model->vencimento = $basicos->formataData('form', $model->vencimento);
            $model->dtpgto = (is_null($model->dtpgto)) ? $model->dtpgto : $basicos->formataData('form', $model->dtpgto);

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Financeiro model.
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
     * Finds the Financeiro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Financeiro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Financeiro::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
