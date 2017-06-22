<?php

namespace backend\modules\mdfe\controllers;

use Yii;
use backend\base\Model;
use backend\modules\mdfe\models\Mdfe;
use backend\modules\mdfe\models\MdfeSearch;
use backend\modules\mdfe\models\MdfeCarregamento as Carregamento;
use backend\modules\mdfe\models\MdfeCondutor as Condutor;
use backend\modules\mdfe\models\MdfeDescarregamento as Descarregamento;
use backend\modules\mdfe\models\MdfeDocumentos as Documentos;
use backend\modules\mdfe\models\MdfePercurso as Percurso;
use backend\models\Municipios;
use backend\models\Funcionarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Mdfe model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all Mdfe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MdfeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mdfe model.
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
     * Creates a new Mdfe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mdfe();
        $modelsCarregamento = [new Carregamento];
        $modelsCondutor = [new Condutor];
        $modelsDescarregamento = [new Descarregamento];
        $modelsDocumentos = [new Documentos];
        $modelsPercurso = [new Percurso];

        $modelMunicipios = new Municipios();
        $municipios = $modelMunicipios->autoComplete();
        $ufs = $modelMunicipios->listarUF();

        $modelPCondutores = new Funcionarios();
        $condutores = $modelPCondutores->autoComplete();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsCarregamento' => (empty($modelsCarregamento)) ? [new Carregamento] : $modelsCarregamento,
                'modelsCondutor' => (empty($modelsCondutor)) ? [new Condutor] : $modelsCondutor,
                'modelsDescarregamento' => (empty($modelsDescarregamento)) ? [new Descarregamento] : $modelsDescarregamento,
                'modelsDocumentos' => (empty($modelsDocumentos)) ? [new Documentos] : $modelsDocumentos,
                'modelsPercurso' => (empty($modelsPercurso)) ? [new Percurso] : $modelsPercurso,
                'municipios' => $municipios,
                'ufs' => $ufs,
                'condutores' => $condutores,
            ]);
        }
    }

    /**
     * Updates an existing Mdfe model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mdfe model.
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
     * Finds the Mdfe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mdfe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mdfe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
