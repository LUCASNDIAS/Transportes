<?php

namespace backend\modules\cte\controllers;

use backend\models\Downloads;
use Yii;
use backend\modules\cte\models\Cte;
use backend\modules\cte\models\CteSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use backend\commands\Basicos;
use yii\helpers\ArrayHelper;
use backend\modules\clientes\models\Clientes;
use yii\filters\AccessControl;
use backend\modules\cte\models\CteDocumentos as Documentos;
use backend\modules\cte\models\CteDimensoes as Dimensoes;
use backend\base\Model;
use backend\modules\veiculos\models\Veiculos;
use backend\modules\cte\models\CteVeiculo;
use backend\models\Funcionarios;
use backend\modules\cte\models\CteMotorista;
use backend\modules\cte\models\CteQtag;
use backend\modules\cte\models\CteComponentes as Componentes;
use backend\modules\cte\models\CteGeral;
use backend\modules\cte\models\CteDocant;
use NFePHP\CTe\Make;
use NFePHP\CTe\Tools;
use backend\models\EnviaEmail;

/**
 * DefaultController implements the CRUD actions for Cte model.
 */
class DefaultController extends Controller
{

    /**
     * behaviors()
     * Controle de acesso
     * @return array
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
        $searchModel = new CteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $autocomplete = new Clientes;
        $data = $autocomplete->autoComplete2();

        return $this->render('index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'data' => $data
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
        $model = new Cte();
        $modelsDocumentos = [new Documentos];
        $modelsComponentes = [new Componentes];
        $modelsDimensoes = [[new Dimensoes]];
        $modelVeiculos = new Veiculos();
        $modelCteVeiculo = new CteVeiculo();
        $modelFuncionarios = new Funcionarios();
        $modelCteMotorista = new CteMotorista();
        $modelCteDocant = new CteDocant();

        $basico = new Basicos();

        $autocomplete = new Clientes;
        $data = $autocomplete->autoComplete();

        $veiculos = $modelVeiculos->getVeiculos();
        $veiculos = \yii\helpers\ArrayHelper::map($veiculos, 'placa', 'modelo');

        $motoristas = $modelFuncionarios->getMotorista();
        $motoristas = \yii\helpers\ArrayHelper::map($motoristas, 'id', 'nome');

        // Parte que salva
        if ($model->load(Yii::$app->request->post())) {

            $modelCteMotorista->load(Yii::$app->request->post());
            $modelCteVeiculo->load(Yii::$app->request->post());
            $modelCteDocant->load(Yii::$app->request->post());

            $modelsDocumentos = Model::createMultiple(Documentos::classname());
            Model::loadMultiple($modelsDocumentos, Yii::$app->request->post());

            $modelsComponentes = Model::createMultiple(Componentes::classname());
            Model::loadMultiple($modelsComponentes, Yii::$app->request->post());

            $model->numero = (empty($model->numero)) ? $this->getNumero($model->ambiente)
                : $model->numero;
            $model->chave = $this->montaChave($model->numero,
                $model->tpemis);
            $model->status = 'SALVO';
            $model->dhcont = date("Y-m-d H:i:s");
            $model->taxaextra = ($model->taxaextra == '') ? 0.00 : $model->taxaextra;
            $model->desconto = ($model->desconto == '') ? 0.00 : $model->desconto;
            $model->dprev = $basico->formataData('db', $model->dprev);
            $model->destinatario = ($model->destinatario == '') ? NULL : $model->destinatario;
            $model->expedidor = ($model->expedidor == '') ? NULL : $model->expedidor;
            $model->recebedor = ($model->recebedor == '') ? NULL : $model->recebedor;

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

                        // Verifica se há motorista (lotação)
                        $modelCteMotorista->cte_id = $last_id;
                        if ($modelCteMotorista->motorista_id != '') {
                            $modelCteMotorista->save(false);
                        }

                        // Verifica se há veículos (lotação)
                        $modelCteVeiculo->cte_id = $last_id;
                        if ($modelCteVeiculo->placa != '') {
                            $modelCteVeiculo->save(false);
                        }

                        // Verifica se é redespacho ou subcontratado
                        $modelCteDocant->cte_id = $last_id;
                        if ($model->tpserv != '0') {
                            $modelCteDocant->save(false);
                        }

                        $qcarga = [
                            'PESO BRUTO' => $model->pesoreal,
                            'PESO CUBADO' => $model->pesocubado,
                            'VOLUMES' => $model->notasvolumes];

                        foreach ($qcarga as $q => $v) {
                            $modelCteQtag = new CteQtag();

                            $modelCteQtag->cte_id = $last_id;
                            $modelCteQtag->cunid = ($q == 'VOLUMES') ? '03' : '01';
                            $modelCteQtag->tpmed = $q;
                            $modelCteQtag->qcarga = $v;

                            $modelCteQtag->save(false);
                        }

                        foreach ($modelsDocumentos as $indexDocumentos => $modelDocumentos) {
                            $modelDocumentos->cte_id = $last_id;
                            $modelDocumentos->demi = date('Y-m-d');

                            if (!($flag2 = $modelDocumentos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            foreach ($_POST['CteDimensoes'][$indexDocumentos] as $dimensoes) {

                                $modelDimensoes = new Dimensoes;

                                //$modelDimensoes->load($dataDim);

                                $modelDimensoes->documento_id = $modelDocumentos->id;
                                $modelDimensoes->altura = $dimensoes['altura'];
                                $modelDimensoes->largura = $dimensoes['largura'];
                                $modelDimensoes->comprimento = $dimensoes['comprimento'];
                                $modelDimensoes->volumes = $dimensoes['volumes'];
                                if (!($flag3 = $modelDimensoes->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
//
//                                    $modelsDimensoes[$indexDocumentos][$indexDimensoes]
//                                        = $modelDimensoes;
                            }
                        }

                        foreach ($modelsComponentes as $modelComponentes) {
                            $modelComponentes->cte_id = $last_id;

                            if (!($flag4 = $modelComponentes->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    //return var_dump($modelsDimensoes);

                    if ($flag && $flag2 && $flag3 && $flag4) {
                        $transaction->commit();
                        //return var_dump('salvo');
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
                'modelCteVeiculo' => $modelCteVeiculo,
                'modelCteMotorista' => $modelCteMotorista,
                'data' => $data,
                'modelsDocumentos' => (empty($modelsDocumentos)) ? [new Documentos]
                    : $modelsDocumentos,
                'modelsDimensoes' => (empty($modelsDimensoes)) ? [[new Dimensoes]]
                    : $modelsDimensoes,
                'modelsComponentes' => (empty($modelsComponentes)) ? [new Componentes]
                    : $modelsComponentes,
                'veiculos' => $veiculos,
                'motoristas' => $motoristas,
                'modelCteDocant' => $modelCteDocant
            ]);
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

        // Somente autoriza a edição se não estiver enviado
        if ($model->status !== 'SALVO') {
            $msg = 'Não é possível editar CT-e com status "' . $model->status . '".';
            return $this->redirect(['index', 'msg' => $msg]);
        }

        $basico = new Basicos();
        $model->dprev = $basico->formataData('form', $model->dprev);

        $modelsDocumentos = $model->cteDocumentos;
        $modelsDimensoes = [];
        $oldDimensoes = [];

        if (!empty($modelsDocumentos)) {
            foreach ($modelsDocumentos as $indexDocumentos => $modelDocumentos) {
                $dimensoes = $modelDocumentos->cteDimensoes;
                $modelsDimensoes[$indexDocumentos] = $dimensoes;
                $oldDimensoes = ArrayHelper::merge(ArrayHelper::index($dimensoes,
                    'id'), $oldDimensoes);
                $modelDocumentos->demi = $basico->formataData('form',
                    $modelDocumentos->demi);
            }
        }

        $modelsComponentes = $model->cteComponentes;
        $modelVeiculos = new Veiculos();
        $modelCteVeiculo = (!empty($model->cteVeiculos)) ? $model->cteVeiculos
            : new CteVeiculo();
        $modelFuncionarios = new Funcionarios();
        $modelCteMotorista = (!empty($model->cteMotoristas)) ? $model->cteMotoristas
            : new CteMotorista();
        $modelCteDocant = (!empty($model->cteDocants)) ? $model->cteDocants[0]
            : new CteDocant();

        $autocomplete = new Clientes;
        $data = $autocomplete->autoComplete();

        $veiculos = $modelVeiculos->getVeiculos();
        $veiculos = \yii\helpers\ArrayHelper::map($veiculos, 'placa', 'modelo');

        $motoristas = $modelFuncionarios->getMotorista();
        $motoristas = \yii\helpers\ArrayHelper::map($motoristas, 'id', 'nome');

        // Parte que salva
        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsComponentes, 'id', 'id');
            $modelsComponentes = Model::createMultiple(Componentes::classname(),
                $modelsComponentes);
            Model::loadMultiple($modelsComponentes, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs,
                array_filter(ArrayHelper::map($modelsComponentes, 'id', 'id')));

            $oldIDsdoc = ArrayHelper::map($modelsDocumentos, 'id', 'id');
            $modelsDocumentos = Model::createMultiple(Documentos::classname(),
                $modelsDocumentos);
            Model::loadMultiple($modelsDocumentos, Yii::$app->request->post());
            $deletedIDsdoc = array_diff($oldIDsdoc,
                array_filter(ArrayHelper::map($modelsDocumentos, 'id', 'id')));

            $dimensoesIDs = [];

            if (isset($_POST['CteDimensoes'][0][0])) {
                foreach ($_POST['CteDimensoes'] as $indexDocumentos => $dimensoes) {
                    $dimensoesIDs = ArrayHelper::merge($dimensoesIDs,
                        array_filter(ArrayHelper::getColumn($dimensoes, 'id')));
                    foreach ($dimensoes as $indexDimensao => $dimensao) {
                        $data['CteDimensoes'] = $dimensao;
                        $modelDimensao = (isset($dimensao['id'])
                            && isset($oldDimensoes[$dimensao['id']])) ? $oldDimensoes[$dimensao['id']]
                            : new Dimensoes;
                        $modelDimensao->load($data);
                        $modelsDimensoes[$indexDocumentos][$indexDimensao] = $modelDimensao;
//                        $valid = $modelDimensao->validate();
                    }
                }
            }

            $oldDimensoesIDs = ArrayHelper::getColumn($oldDimensoes, 'id');
            $deletedDimensoesIDs = array_diff($oldDimensoesIDs, $dimensoesIDs);

            // Parte antiga de salvar quando se em create

            $modelCteMotorista = new CteMotorista();
            $modelCteVeiculo = new CteVeiculo();
//            $modelCteDocant   = new CteDocant();

            $modelCteMotorista->load(Yii::$app->request->post());
            $modelCteVeiculo->load(Yii::$app->request->post());
            $modelCteDocant->load(Yii::$app->request->post());
//
//            $modelsDocumentos = Model::createMultiple(Documentos::classname());
//            Model::loadMultiple($modelsDocumentos, Yii::$app->request->post());
//
//            $modelsComponentes = Model::createMultiple(Componentes::classname());
//            Model::loadMultiple($modelsComponentes, Yii::$app->request->post());

            $model->numero = (empty($model->numero)) ? $this->getNumero($model->ambiente)
                : $model->numero;
            $model->chave = $this->montaChave($model->numero,
                $model->tpemis);
            $model->status = 'SALVO';
            //$model->dhcont    = date("Y-m-d H:i:s");
            $model->taxaextra = ($model->taxaextra == '') ? 0.00 : $model->taxaextra;
            $model->desconto = ($model->desconto == '') ? 0.00 : $model->desconto;
            $model->dprev = $basico->formataData('db', $model->dprev);
            $model->destinatario = ($model->destinatario == '') ? NULL : $model->destinatario;
            $model->expedidor = ($model->expedidor == '') ? NULL : $model->expedidor;
            $model->recebedor = ($model->recebedor == '') ? NULL : $model->recebedor;

            // validate all models
            $valid = $model->validate();
//            $valid = Model::validateMultiple($modelsContatos) && $valid;
//            $valid = Model::validateMultiple($modelsTabelas) && $valid;

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        if (!empty($oldDimensoesIDs)) {
                            Dimensoes::deleteAll(['id' => $oldDimensoesIDs]);
                        }

                        if (!empty($deletedIDsdoc)) {
                            Documentos::deleteAll(['id' => $deletedIDsdoc]);
                        }

                        if (!empty($deletedIDs)) {
                            Componentes::deleteAll(['id' => $deletedIDs]);
                        }

//                        $last_id = \Yii::$app->db->getLastInsertID();
                        $last_id = $model->id;

                        // Verifica se há motorista (lotação)
                        $modelCteMotorista->cte_id = $last_id;
                        if ($modelCteMotorista->motorista_id != '') {
                            $modelCteMotorista->save(false);
                        }

                        // Verifica se há veículos (lotação)
                        $modelCteVeiculo->cte_id = $last_id;
                        if ($modelCteVeiculo->placa != '') {
                            $modelCteVeiculo->save(false);
                        }

                        // Verifica se é redespacho ou subcontratado
                        $modelCteDocant->cte_id = $last_id;
                        if ($model->tpserv != '0') {
                            $modelCteDocant->save(false);
                        }

                        $qcarga = [
                            'PESO BRUTO' => $model->pesoreal,
                            'PESO CUBADO' => $model->pesocubado,
                            'VOLUMES' => $model->notasvolumes];
//
                        foreach ($qcarga as $q => $v) {
                            $modelCteQtag = new CteQtag();

                            $modelCteQtag->cte_id = $last_id;
                            $modelCteQtag->cunid = ($q == 'VOLUMES') ? '03' : '01';
                            $modelCteQtag->tpmed = $q;
                            $modelCteQtag->qcarga = $v;

                            $modelCteQtag->save(false);
                        }

                        foreach ($modelsDocumentos as $indexDocumentos => $modelDocumentos) {
                            $modelDocumentos->cte_id = $last_id;
                            $modelDocumentos->demi = date('Y-m-d');

                            if (!($flag2 = $modelDocumentos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            foreach ($_POST['CteDimensoes'][$indexDocumentos] as $dimensoes) {

                                $modelDimensoes = new Dimensoes;

                                //$modelDimensoes->load($dataDim);

                                $modelDimensoes->documento_id = $modelDocumentos->id;
                                $modelDimensoes->altura = $dimensoes['altura'];
                                $modelDimensoes->largura = $dimensoes['largura'];
                                $modelDimensoes->comprimento = $dimensoes['comprimento'];
                                $modelDimensoes->volumes = $dimensoes['volumes'];
                                if (!($flag3 = $modelDimensoes->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
//
//                                    $modelsDimensoes[$indexDocumentos][$indexDimensoes]
//                                        = $modelDimensoes;
                            }
                        }

                        foreach ($modelsComponentes as $modelComponentes) {
                            $modelComponentes->cte_id = $last_id;

                            if (!($flag4 = $modelComponentes->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    //return var_dump($modelsDimensoes);

                    if ($flag && $flag2 && $flag3 && $flag4) {
                        $transaction->commit();
                        //return var_dump('salvo');
                        //return $this->redirect(['index']);
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update',
            [
                'model' => $model,
                'modelCteVeiculo' => (empty($modelCteVeiculo)) ? $modelCteVeiculo
                    : new CteVeiculo(),
                'modelCteMotorista' => (empty($modelCteMotorista)) ? $modelCteMotorista
                    : new CteMotorista(),
                'data' => $data,
                'modelsDocumentos' => (empty($modelsDocumentos)) ? [new Documentos]
                    : $modelsDocumentos,
                'modelsDimensoes' => (empty($modelsDimensoes)) ? [[new Dimensoes]]
                    : $modelsDimensoes,
                'modelsComponentes' => (empty($modelsComponentes)) ? [new Componentes]
                    : $modelsComponentes,
                'veiculos' => $veiculos,
                'motoristas' => $motoristas,
                'modelCteDocant' => $modelCteDocant,
            ]);
    }

    /**
     * Validador
     * CrossOrigin para validar CT-e na Sefaz RS
     * @return string
     */
    public function actionValidador()
    {
        return $this->renderPartial('validador');
    }

    /**
     * Deletes an existing Cte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);

        $msg = "Registro com status \"" . $model->status . "\" não pode ser deletado.";

        if ($model->status == 'SALVO') {
            $model->status = 'DELETADO';
            $model->save(false);

            $msg = "Registro removido com sucesso.";
        }

        return $this->redirect(['index', 'msg' => $msg]);
    }

    /**
     * CancelEnviarXml()
     * Solicita cancelamento de CTe
     * @param $id
     * @return array|string
     */
    public function actionCancelEnviarXml($id, $motivo)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->cancelEnviarXml($id, $motivo);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * GerarXml()
     * Gera xml  de um determinado CTe
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGerarXml($id)
    {
        $model = $this->findModel($id);
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->gerarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * AssinarXml()
     * Assina um XML gerado
     * @param $id
     * @return array
     */
    public function actionAssinarXml($id)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->assinarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * Validar()
     * Valida um XML assinado
     * @param $id
     * @return array
     */
    public function actionValidarXml($id)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->validarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * EnviarXml()
     * Transmite um XML para a sefaz
     * @param $id
     * @return array|string
     */
    public function actionEnviarXml($id)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->enviarXml($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * ReciboXml()
     * Consulta e salva recibo (retorno) da Sefaz
     * @param $id
     * @param $recibo
     * @return array
     */
    public function actionReciboXml($id, $recibo)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->reciboXml($id, $recibo);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * ProtocoloXml()
     * Salva protocolo de autorização
     * @param $id
     * @param $recibo
     * @return array
     */
    public function actionProtocoloXml($id, $recibo)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->protocoloXml($id, $recibo);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * GerarPdf
     * gera pdf para impressão ou envio
     * @param $id
     * @return array
     */
    public function actionGerarPdf($id)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->gerarPdf($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * Print()
     * Gera arquivo para impressão
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionPrint($id)
    {
        $this->actionGerarPdf($id);

        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $url1 = str_replace('Transportes/backend/web', '', Yii::getAlias('@web'));
        //$url1 = 'http://geradorfiscal.com.br/';

        $url = $url1 . 'sped/cte' . DIRECTORY_SEPARATOR . Yii::$app->user->identity['cnpj'] .
            DIRECTORY_SEPARATOR . $pamb . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR .
            $model->chave . '-cte.pdf';

//        return var_dump($url);

        return $this->redirect($url);
    }

    /**
     * Download()
     * Faz download dos XMLs
     * @param $id
     * @return \yii\console\Response|Response
     * @throws NotFoundHttpException
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        $chave = $model->chave;

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $status = $model->status;

        // Arquivo Autorizado
        $autorizado = Yii::getAlias('@cte/') . Yii::$app->user->identity['cnpj'] . '/' . $pamb . '/enviadas/aprovadas/' . $model->chave . '-cte.xml';

        // Arquivo Cancelado
        $cancelado = Yii::getAlias('@cte/') . Yii::$app->user->identity['cnpj'] . '/' . $pamb . '/canceladas/' . $model->chave . '-cte.xml';

        $xml = (is_file($cancelado)) ? $cancelado : $autorizado;

        if (is_file($xml)) {

            return \Yii::$app->response->sendFile($xml);
        } else {
            echo 'nao';
            var_dump($xml);
        }
    }

    /**
     * Send()
     * Envia XML
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
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

        $cteTools = new Tools(Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json');

        // Arquivo Validado
        $validado = Yii::getAlias('@cte/') . Yii::$app->user->identity['cnpj'] . '/' . $pamb . '/validadas/' . $model->chave . '-cte.xml';

        return $this->render('send',
            [
                'model' => $model
            ]);
    }

    /**
     * GetXml()
     * Retorna conteúdo de um XML
     * @param $id
     * @return bool|string
     * @throws NotFoundHttpException
     */
    public function actionGetXml($id)
    {
        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo Validado
        $validado = Yii::getAlias('@cte/') . Yii::$app->user->identity['cnpj'] . '/' . $pamb . '/validadas/' . $model->chave . '-cte.xml';

        $texto = file_get_contents($validado);

        Yii::$app->response->format = Response::FORMAT_XML;

        return $texto;
    }

    /**
     * Cancel()
     * Cancelar CTe
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCancel($id)
    {
        $model = $this->findModel($id);

//        // Somente acessa se estiver autorizado
//        if ($model->status !== 'AUTORIZADO') {
//            $msg = 'Não é possível cancelar CT-e com status "' . $model->status . '".';
//            return $this->redirect(['index', 'msg' => $msg]);
//        }

        return $this->render('cancel',
            [
                'model' => $model,
                'retorno' => (isset($retorno)) ? $retorno : []
            ]);
    }

    public function actionCancelamento($id, $motivo)
    {
        $model = $this->findModel($id);

        if ($motivo != '') {
            $cteGeral = new CteGeral();
            $retorno = $cteGeral->sefazCancela($id, $motivo);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $retorno;

    }

    /**
     * ConsultaChave()
     * Consulta CTe pela chave
     * @param $id
     * @return array
     */
    public function actionConsultaChave($id)
    {
        $cteGeral = new CteGeral();

        $retorno = $cteGeral->consultaChave($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $retorno;
    }

    /**
     * Email()
     * Envia PDF e XML para cliente por email
     * @param $id
     * @return mixed|string
     * @throws NotFoundHttpException
     */
    public function actionEmail($id)
    {

        // Modelo do CTe
        $model = $this->findModel($id);

        if (!\Yii::$app->request->isAjax) {

            // Email dos envolvidos
            $envolvidos = new Clientes();
            $remetente = $envolvidos->getEmail($model->remetente);
            $destinatario = $envolvidos->getEmail($model->destinatario);
            $consignatario = $envolvidos->getEmail($model->tomador);

            return $this->render('email',
                [
                    'model' => $model,
                    'remetente' => $remetente,
                    'destinatario' => $destinatario,
                    'consignatario' => $consignatario
                ]);
        } else {

            // Verifica se é homologação ou produção
            $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

            // Anexos
            $pdf = Yii::getAlias('@cte/') . Yii::$app->user->identity['cnpj'] . '/' . $pamb . '/pdf/' . $model->chave . '-cte.pdf';

            $pasta = ($model->status == 'AUTORIZADO' || $model->status == 'ENTREGUE') ? '/enviadas/aprovadas/' : '/canceladas/';

            $xml = Yii::getAlias('@cte/') . Yii::$app->user->identity['cnpj'] . '/' . $pamb . $pasta . $model->chave . '-cte.xml';

            // Verifica se o arquivo existe
            if (!is_file($pdf)) {
                return 'Anexo não encontrado!';
            } else {

                // Parametros passados por POST (ajax)
                $EmailDestinatario = explode(',',
                    Yii::$app->request->get('emails'));

                // Título do Email
                $titulo = 'Gerador Fiscal | ' . \Yii::$app->user->identity['empresa'] . ' - CTe ' . $model->numero;

                $dados['remetente'] = $model->remetente;
                $dados['destinatario'] = $model->destinatario;
                $dados['consignatario'] = $model->tomador;
                $dados['numero'] = $model->numero;

                $EnviaEmail = new EnviaEmail();
                $Envia = $EnviaEmail->enviarCte($EmailDestinatario,
                    $titulo, $pdf, $xml, $dados);

                return $Envia;
            }
        }
    }

    /**
     * Baixar()
     * Baixar entrega de um CTe
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBaixar($id)
    {
        $model = $this->findModel($id);
        $basico = new Basicos();

        if ($model->load(Yii::$app->request->post())) {

            $model->status = ($model->ent_data == '') ? $model->status : 'ENTREGUE';
            $model->ent_data = $basico->formataData('db', $model->ent_data);

            $model->save();

            $this->redirect('index');
        } else {
            $model->ent_data = $basico->formataData('form', $model->ent_data);
        }

        return $this->render('baixar',
            [
                'model' => $model,
            ]);
    }

    /**
     * Downloads()
     * Baixar arquivos XML do emissor
     * @return string|\yii\console\Response|Response|\ZipArchive
     */
    public function actionDownloads()
    {
        if (!empty(Yii::$app->request->post())) {

            $modelDownloads = new Downloads();

            // Dados do formulário
            $formulario = Yii::$app->request->post();

            $files = $modelDownloads->aplicaFiltro($formulario);

            $retorno = $modelDownloads->criarZip($files);

            if (isset($retorno['erro'])) {
                return $this->render('downloads', [
                    'msg' => 'Nenhum CTe encontrado com os filtros selecionados.'
                ]);
            } else {
                return \Yii::$app->response->sendFile($retorno);
            }
        }

        return $this->render('downloads', [
            'msg' => ''
        ]);

        return $retorno;
    }

    /**
     * montaChave()
     * Cria chave para o CTe
     * @param $numero
     * @param $tpEmis
     * @return string
     */
    protected function montaChave($numero, $tpEmis)
    {
        //$mdfeTools = new Tools(Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json');
        $cte = new Make();
        $chave = $cte->montaChave('31', date('y'), date('m'),
            Yii::$app->user->identity['cnpj'], '57', '1', $numero, $tpEmis,
            '09835783');
        return $chave;
    }

    /**
     * getNumero()
     * Verifica o número do último CTe do ambiente
     * @param $tpAmb
     * @return int|mixed
     */
    protected function getNumero($tpAmb)
    {
        $model = new Cte();
        $last = $model->getLastId($tpAmb);

        return $last;
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