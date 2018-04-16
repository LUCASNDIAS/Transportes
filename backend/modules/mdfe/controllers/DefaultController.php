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
use backend\modules\cte\models\Cte;
use backend\models\Municipios;
use backend\models\Funcionarios;
use backend\modules\clientes\models\Clientes;
use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\modules\mdfe\models\MdfeGeral;
use yii\web\Response;

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
        $searchModel  = new MdfeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',
                [
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
        return $this->render('view',
                [
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
        $model                 = new Mdfe();
        $modelsCarregamento    = [new Carregamento];
        $modelsCondutor        = [new Condutor];
        $modelsDescarregamento = [new Descarregamento];
        $modelsDocumentos      = [new Documentos];
        $modelsPercurso        = [new Percurso];

        $modelMunicipios = new Municipios();
        $municipios      = $modelMunicipios->autoComplete();
        $ufs             = $modelMunicipios->listarUF();

        $modelPCondutores = new Funcionarios();
        $condutores       = $modelPCondutores->autoComplete();

//        $modelCte = new Cte();
//        $ctes = $modelCte->autocomplete();

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())
            && Yii::$app->request->post('salvar') === null) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $modelsCarregamento = Model::createMultiple(Carregamento::classname());
            Model::loadMultiple($modelsCarregamento, Yii::$app->request->post());

            $modelsCondutor = Model::createMultiple(Condutor::classname());
            Model::loadMultiple($modelsCondutor, Yii::$app->request->post());

            $modelsDescarregamento = Model::createMultiple(Descarregamento::classname());
            Model::loadMultiple($modelsDescarregamento,
                Yii::$app->request->post());

            $modelsDocumentos = Model::createMultiple(Documentos::classname());
            Model::loadMultiple($modelsDocumentos, Yii::$app->request->post());

            $modelsPercurso = Model::createMultiple(Percurso::classname());
            Model::loadMultiple($modelsPercurso, Yii::$app->request->post());

            $model->numero = (empty($model->numero)) ? $this->getNumero($model->ambiente)
                    : $model->numero;
            $model->chave  = $this->montaChave($model->numero,
                $model->formaemissao);
            $model->status = 'SALVO';

            // validate all models
            $valid = $model->validate();
//            $valid = Model::validateMultiple($modelsContatos) && $valid;
//            $valid = Model::validateMultiple($modelsTabelas) && $valid;
//
//            return var_dump($model->errors);
            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        $last_id = \Yii::$app->db->getLastInsertID();

                        foreach ($modelsCarregamento as $modelCarregamento) {
                            $modelCarregamento->mdfe_id = $last_id;

                            if (!($flag = $modelCarregamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsCondutor as $modelCondutor) {
                            $modelCondutor->mdfe_id = $last_id;

                            if (!($flag2 = $modelCondutor->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsDescarregamento as $modelDescarregamento) {
                            $modelDescarregamento->mdfe_id = $last_id;

                            if (!($flag3 = $modelDescarregamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsDocumentos as $modelDocumentos) {
                            $modelDocumentos->mdfe_id = $last_id;

                            if (!($flag4 = $modelDocumentos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsPercurso as $modelPercurso) {
                            $modelPercurso->mdfe_id = $last_id;

                            if (!($flag5 = $modelPercurso->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag && $flag2 && $flag3 && $flag4) {
                        $transaction->commit();
                        return $this->redirect(['index']);
//                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create',
                [
                'model' => $model,
                'modelsCarregamento' => (empty($modelsCarregamento)) ? [new Carregamento]
                    : $modelsCarregamento,
                'modelsCondutor' => (empty($modelsCondutor)) ? [new Condutor] : $modelsCondutor,
                'modelsDescarregamento' => (empty($modelsDescarregamento)) ? [
                new Descarregamento] : $modelsDescarregamento,
                'modelsDocumentos' => (empty($modelsDocumentos)) ? [new Documentos]
                    : $modelsDocumentos,
                'modelsPercurso' => (empty($modelsPercurso)) ? [new Percurso] : $modelsPercurso,
                'municipios' => $municipios,
                'ufs' => $ufs,
                'condutores' => $condutores,
//                'ctes' => $ctes
        ]);
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

        // Somente autoriza a edição se não estiver enviado
        if ($model->status !== 'SALVO') {
            return $this->redirect(['index']);
        }

        $modelsCarregamento    = $model->mdfeCarregamentos;
        $modelsCondutor        = $model->mdfeCondutors;
        $modelsDescarregamento = $model->mdfeDescarregamentos;
        $modelsDocumentos      = $model->mdfeDocumentos;
        $modelsPercurso        = $model->mdfePercursos;

        $modelMunicipios = new Municipios();
        $municipios      = $modelMunicipios->autoComplete();
        $ufs             = $modelMunicipios->listarUF();

        $modelPCondutores = new Funcionarios();
        $condutores       = $modelPCondutores->autoComplete();

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())
            && Yii::$app->request->post('salvar') === null) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs             = ArrayHelper::map($modelsCarregamento, 'id',
                    'id');
            $modelsCarregamento = Model::createMultiple(Carregamento::classname(),
                    $modelsCarregamento);
            Model::loadMultiple($modelsCarregamento, Yii::$app->request->post());
            $deletedIDs         = array_diff($oldIDs,
                array_filter(ArrayHelper::map($modelsCarregamento, 'id', 'id')));

            $oldIDscon      = ArrayHelper::map($modelsCondutor, 'id', 'id');
            $modelsCondutor = Model::createMultiple(Condutor::classname(),
                    $modelsCondutor);
            Model::loadMultiple($modelsCondutor, Yii::$app->request->post());
            $deletedIDscon  = array_diff($oldIDscon,
                array_filter(ArrayHelper::map($modelsCondutor, 'id', 'id')));

            $oldIDsdes             = ArrayHelper::map($modelsDescarregamento,
                    'id', 'id');
            $modelsDescarregamento = Model::createMultiple(Descarregamento::classname(),
                    $modelsDescarregamento);
            Model::loadMultiple($modelsDescarregamento,
                Yii::$app->request->post());
            $deletedIDsdes         = array_diff($oldIDsdes,
                array_filter(ArrayHelper::map($modelsDescarregamento, 'id', 'id')));

            $oldIDsdoc        = ArrayHelper::map($modelsDocumentos, 'id', 'id');
            $modelsDocumentos = Model::createMultiple(Documentos::classname(),
                    $modelsDocumentos);
            Model::loadMultiple($modelsDocumentos, Yii::$app->request->post());
            $deletedIDsdoc    = array_diff($oldIDsdoc,
                array_filter(ArrayHelper::map($modelsDocumentos, 'id', 'id')));

            $oldIDsper      = ArrayHelper::map($modelsPercurso, 'id', 'id');
            $modelsPercurso = Model::createMultiple(Percurso::classname(),
                    $modelsPercurso);
            Model::loadMultiple($modelsPercurso, Yii::$app->request->post());
            $deletedIDsper  = array_diff($oldIDsper,
                array_filter(ArrayHelper::map($modelsPercurso, 'id', 'id')));

            $model->chave = $this->montaChave($model->numero,
                $model->formaemissao);

            // validate all models
            $valid = $model->validate();

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        if (!empty($deletedIDs)) {
                            Carregamento::deleteAll(['id' => $deletedIDs]);
                        }

                        if (!empty($deletedIDscon)) {
                            Condutor::deleteAll(['id' => $deletedIDscon]);
                        }

                        if (!empty($deletedIDsdes)) {
                            Descarregamento::deleteAll(['id' => $deletedIDsdes]);
                        }

                        if (!empty($deletedIDsdoc)) {
                            Documentos::deleteAll(['id' => $deletedIDsdoc]);
                        }

                        if (!empty($deletedIDsper)) {
                            Percurso::deleteAll(['id' => $deletedIDsper]);
                        }

                        $last_id = $model->id;

                        foreach ($modelsCarregamento as $modelCarregamento) {
                            $modelCarregamento->mdfe_id = $last_id;

                            if (!($flag = $modelCarregamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsCondutor as $modelCondutor) {
                            $modelCondutor->mdfe_id = $last_id;

                            if (!($flag2 = $modelCondutor->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsDescarregamento as $modelDescarregamento) {
                            $modelDescarregamento->mdfe_id = $last_id;

                            if (!($flag3 = $modelDescarregamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsDocumentos as $modelDocumentos) {
                            $modelDocumentos->mdfe_id = $last_id;

                            if (!($flag4 = $modelDocumentos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsPercurso as $modelPercurso) {
                            $modelPercurso->mdfe_id = $last_id;

                            if (!($flag5 = $modelPercurso->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag && $flag2 && $flag3 && $flag4) {

                        $transaction->commit();
                        return $this->redirect(['index']);
//                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update',
                [
                'model' => $model,
                'modelsCarregamento' => (empty($modelsCarregamento)) ? [new Carregamento]
                    : $modelsCarregamento,
                'modelsCondutor' => (empty($modelsCondutor)) ? [new Condutor] : $modelsCondutor,
                'modelsDescarregamento' => (empty($modelsDescarregamento)) ? [
                new Descarregamento] : $modelsDescarregamento,
                'modelsDocumentos' => (empty($modelsDocumentos)) ? [new Documentos]
                    : $modelsDocumentos,
                'modelsPercurso' => (empty($modelsPercurso)) ? [new Percurso] : $modelsPercurso,
                'municipios' => $municipios,
                'ufs' => $ufs,
                'condutores' => $condutores,
        ]);
    }

    public function actionSend($id)
    {
        $model = $this->findModel($id);

        // Não acessa caso esteja cancelado
//        if ($model->status === 'CANCELADO') {
//            $msg = 'Não é possível transmitir CT-e já cancelado.';
//            return $this->redirect(['index', 'msg' => $msg]);
//        }
        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Arquivo Validado
        $validado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-mdfe.xml';

        return $this->render('send',
                [
                'model' => $model
        ]);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);

//        // Somente acessa se estiver autorizado
//        if ($model->status !== 'AUTORIZADO') {
//            $msg = 'Não é possível cancelar CT-e com status "' . $model->status . '".';
//            return $this->redirect(['index', 'msg' => $msg]);
//        }

        $formulario = Yii::$app->request->post();

        if (!empty($formulario)) {
            if ($formulario['motivo'] != '') {
                $mdfeGeral = new MdfeGeral();
                $retorno  = $mdfeGeral->sefazCancela($id, $formulario['motivo']);
            }
        }

        return $this->render('cancel',
                [
                'model' => $model,
                'retorno' => (isset($retorno)) ? $retorno : [],
                'formulario' => $formulario
        ]);
    }

    /**
     * Deletes an existing Mdfe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model         = $this->findModel($id);
        $model->status = 'DELETADO';
        $model->save();

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

    protected function montaChave($numero, $tpEmis)
    {
        //$mdfeTools = new Tools(Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json');
        $mdfe  = new Make();
        $chave = $mdfe->montaChave('31', date('y'), date('m'),
            Yii::$app->user->identity['cnpj'], '58', '1', $numero, $tpEmis,
            '09835783');
        return $chave;
    }

    protected function getNumero($tpAmb)
    {
        $model = new Mdfe();
        $last  = $model->getLastId($tpAmb);

        return $last;
    }

    public function actionXml($id)
    {
        $gerar = new MdfeGeral();
        echo '<pre>';
        var_dump($gerar->gerarXml($id));
    }

    public function actionTestamdfe()
    {
        return $this->render('testaMakeMdfe');
    }

    public function actionEncerrar($id)
    {
        $model = $this->findModel($id);

        $modelMunicipios = new Municipios();
        $municipios      = $modelMunicipios->autoComplete();
        $ufs             = $modelMunicipios->listarUFCod();

        $formulario = Yii::$app->request->post();

        if (!empty($formulario)) {
            if ($formulario['cMun'] != '' && $formulario['cUF'] != '') {
                $mdfeGeral = new MdfeGeral();
                $retorno  = $mdfeGeral->sefazEncerra($id, $formulario['cUF'], $formulario['cMun']);
            }
        }

        return $this->render('encerrar',
                [
                'model' => $model,
                'retorno' => (isset($retorno)) ? $retorno : [],
                'formulario' => $formulario,
                'ufs' => $ufs,
                'municipios' => $municipios
        ]);

    }

    public function actionConsultaEncerrados()
    {
        $mdfeTools = new Tools(Yii::getAlias('@sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');
        $aRetorno = array();
        $encerra = $mdfeTools->sefazConsultaNaoEncerrados('2', Yii::$app->user->identity['cnpj'], $aRetorno);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $aRetorno;

    }

    public function actionGerarXml($id)
    {
        $model    = $this->findModel($id);
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->gerarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionAssinarXml($id)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->assinarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionValidarXml($id)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->validarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionEnviarXml($id)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->enviarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionReciboXml($id, $recibo)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->reciboXml($id, $recibo);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionProtocoloXml($id, $recibo)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->protocoloXml($id, $recibo);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionGerarPdf($id)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->gerarPdf($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    public function actionPrint($id)
    {
        $this->actionGerarPdf($id);

        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $url1 = str_replace('Transportes/backend/web', '', Yii::getAlias('@web'));
        //$url1 = 'http://geradorfiscal.com.br/';

        $url = $url1.'sped/mdfe'.DIRECTORY_SEPARATOR.Yii::$app->user->identity['cnpj'].
            DIRECTORY_SEPARATOR.$pamb.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.
            $model->chave.'-mdfe.pdf';

//        return var_dump($url);

        return $this->redirect($url);
    }

    public function actionConsultaChave($id)
    {
        $mdfeGeral = new MdfeGeral();

        $retorno = $mdfeGeral->consultaChave($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }
}