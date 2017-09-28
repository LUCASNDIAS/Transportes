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
use backend\modules\clientes\models\Clientes;
use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        $model       = $this->findModel($id);
        $emitente    = Clientes::findOne(['cnpj' => Yii::$app->user->identity['cnpj']]);
        $condutores  = Condutor::findAll(['mdfe_id' => $id]);
        $munCarga    = Carregamento::findAll(['mdfe_id' => $id]);
        $munDescarga = Descarregamento::findAll(['mdfe_id' => $id]);
        $documentos  = Documentos::findAll(['mdfe_id' => $id]);
        $munPercurso = Percurso::findAll(['mdfe_id' => $id]);

        return $this->render('enviaXML',
                [
                'model' => $model,
                'munCarga' => $munCarga,
                'munDescarga' => $munDescarga,
                'munPercurso' => $munPercurso,
                'condutores' => $condutores,
                'documentos' => $documentos,
                'emitente' => $emitente
        ]);
    }

    public function actionCte()
    {
        return $this->render('cte');
    }

    public function actionCteprot()
    {
        return $this->render('cteprot');
    }

    /**
     * Cria o arquivo PDF do MDFe
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id, $retorno = true)
    {
        // Modelo do Manifesto
        $model      = $this->findModel($id);
        $condutores = Condutor::findAll(['mdfe_id' => $id]);

        // Verifica se o Usuario atual eh dono do Manifesto
        if ($model->dono != \Yii::$app->user->identity['cnpj']) {
            $exception = 'Permissão negada.';
            return $this->redirect('site/error');
        }

        $this->layout = '@backend/views/layouts/print';

        return $this->render('print',
                [
                'model' => $model,
                'condutores' => $condutores,
        ]);

//        // Define o layout para impressão
//        $this->layout = 'minutas-print';
////
//        $conteudoPDF = $this->render('print');
////            'model' => $model,
////            'empresa' => $empresa,
////            'remetente' => $remetente,
////            'destinatario' => $destinatario,
////            'consignatario' => $consignatario,
////            'tabela' => $tabela,
////        ]);
////
//        // Local para se salvar as Minutas em PDF
//        $path = 'pdfs/LNDSistemas-Mdfe' . $model->numero . '.pdf';
////
//        Yii::$app->html2pdf
//                ->convert($conteudoPDF)
//                ->saveAs($path);
//
//        if (!$retorno) {
//            return $path;
//        }
//
//        if (is_file($path)) {
//
//            // Set up PDF headers
//            header('Content-type: application/pdf');
//            header('Content-Disposition: inline; filename="' . '/LNDSistemas-M' . $model->numero . '.pdf' . '"');
//            header('Content-Transfer-Encoding: binary');
//            header('Content-Length: ' . filesize($path));
//            header('Accept-Ranges: bytes');
//
//            // Retorna arquivo PDF
//            return readfile($path);
//        } else {
//            // Retorna arquivo PHP
//            return $conteudoPDF;
//        }
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

    public function actionStatus()
    {
        return $this->render('status');
    }

    public function actionValida()
    {
        return $this->render('valida');
    }

    public function actionCriarxml()
    {
        return $this->render('criarxml');
    }

    public function actionEncerrar()
    {
        return $this->render('encerrar');
    }

    public function actionConsultachave()
    {
        return $this->render('consultachave');
    }

    public function actionCancel()
    {
        return $this->render('cancelar');
    }

    public function actionPrepara($id)
    {
        $model     = $this->findModel($id);
        $modelXml  = new \backend\modules\mdfe\models\MontaXml;
        $assinado  = $modelXml->montarXml($id);
        $xAmbiente = ($model->ambiente == 1) ? 'producao' : 'homologacao';
        $novo      = \Yii::getAlias('@mdfe').'/'.$xAmbiente.'/validadas/'.$model->chave.'-mdfe.xml';

        if (is_file($assinado)) {
            $valida = $modelXml->validaXml($assinado);
            if (!is_array($valida)) {
                rename($assinado, $novo);
                return [
                    'status' => 'OK',
                    'xml' => $novo
                ];
            } else {
                return ['status' => 'ERRO', 'ERROS' => $valida];
            }
        }
    }

    public function actionEnvia($id, $xml)
    {
        $model      = $this->findModel($id);
        $tpAmb      = $model->ambiente;
        $modelEnvia = new \backend\modules\mdfe\models\MontaXml();
        $envia = $modelEnvia->enviaXml($xml, $tpAmb);

        var_dump($envia);
    }

    public function actionVai($id)
    {
        $prepara = $this->actionPrepara($id);

        if($prepara['status'] == 'OK') {
            $retorno = $this->actionEnvia($id, $prepara['xml']);
            var_dump($retorno);
        } else {
            var_dump($prepara);
        }
        
    }
}