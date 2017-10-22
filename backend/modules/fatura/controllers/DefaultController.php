<?php

namespace backend\modules\fatura\controllers;

use Yii;
use backend\modules\fatura\models\Fatura;
use backend\modules\fatura\models\FaturaSearch;
use backend\models\MinutasSearch;
use backend\modules\cte\models\CteSearch;
use backend\modules\fatura\models\FaturaDocumentos as Documentos;
use backend\modules\clientes\models\Clientes;
use backend\modules\financeiro\models\Financeiro;
use backend\models\EnviaEmail;
use backend\commands\Basicos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Fatura model.
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
     * Lists all Fatura models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new FaturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',
                [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fatura model.
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
     * Creates a new Fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model        = new Fatura();
        $searchModel  = new MinutasSearch();
        $dataProvider = $searchModel->searchMinutas(Yii::$app->request->queryParams);
        $basicos      = new Basicos();

        if ($model->load(Yii::$app->request->post())) {

            $model->numero     = ($model->numero == '') ? $this->getNumero() : $model->numero;
            $model->status     = 'GERADA';
            $model->emissao    = $basicos->formataData('db', $model->emissao);
            $model->vencimento = $basicos->formataData('db', $model->vencimento);

            $embarques = explode('/', Yii::$app->request->post('embarques'));

            if ($model->save()) {

                $last_id = $model->id;

                foreach ($embarques as $embarque) {
                    $documento            = new Documentos;
                    $documento->fatura_id = $last_id;
                    $documento->minuta_id = $embarque;
                    $documento->save();
                    unset($documento);
                }

                $financeiro              = new \backend\modules\financeiro\models\Financeiro();
                $financeiro->nome        = 'FATURA '.$model->numero;
                $financeiro->descricao   = 'FATURA DE '.$model->tipo;
                $financeiro->tipo        = 'R';
                $financeiro->emissao     = $model->emissao;
                $financeiro->vencimento  = $model->vencimento;
                $financeiro->dono        = $model->dono;
                $financeiro->cridt       = $model->cridt;
                $financeiro->criusu      = $model->criusu;
                $financeiro->observacoes = $model->observacoes;
                $hoje                    = date('Y-m-d');

                $financeiro->status = ($hoje <= $financeiro->vencimento) ? 'A VENCER' : 'VENCIDO';

                $cpl = $this->getDocs($last_id);

                $financeiro->valor = $cpl['total']['frete'];
                $financeiro->sacado = $model->sacado;
                $financeiro->fatura = $last_id;
                $financeiro->save(false);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create',
                    [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Creates a new Fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCte()
    {
        $model        = new Fatura();
        $searchModel  = new CteSearch();
        $dataProvider = $searchModel->searchCte(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {

            $model->numero     = ($model->numero == '') ? $this->getNumero() : $model->numero;
            $model->status     = 'GERADA';
            $model->emissao    = $basicos->formataData('db', $model->emissao);
            $model->vencimento = $basicos->formataData('db', $model->vencimento);

            $embarques = explode('/', Yii::$app->request->post('embarques'));

            if ($model->save()) {

                $last_id = $model->id;

                foreach ($embarques as $embarque) {
                    $documento            = new Documentos;
                    $documento->fatura_id = $last_id;
                    $documento->cte_id    = $embarque;
                    $documento->save();
                    unset($documento);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create-cte',
                    [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Fatura model.
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
     * Deletes an existing Fatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $fatura = $this->findModel($id);
        
        // Deleta documentos (minutas ou ctes)
        $docs = $this->findModelDocs($id);
        foreach ($docs as $doc) {
            $doc->delete();
        }

        // Deleta financeiro
        $this->findModelFinanceiro($id)->delete();

        // Detela fatura
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPrint($id, $retorno = true)
    {

        $model = $this->findModel($id);

        // Modelo de dados dos Clientes
        // Usado para Empresa, Remetente, Destinatario e Consignatario
        $cnpj         = Yii::$app->user->identity['cnpj'];
        $modelCliente = new Clientes();
        $empresa      = $modelCliente->retornaCliente($cnpj);
        $sacado       = $modelCliente->retornaCliente($model->sacado);
        $docs         = $this->getDocs($id);

        $this->layout = 'fatura-print';

        $conteudoPDF = $this->render('print',
            [
            'model' => $model,
            'empresa' => $empresa,
            'sacado' => $sacado,
            'docs' => $docs,
        ]);

        // Local para se salvar as Minutas em PDF
        $path = 'pdfs/faturas/'.\Yii::$app->user->identity['cnpj'].'/LNDSistemas-F'.$model->numero.'.pdf';

        Yii::$app->html2pdf
            ->convert($conteudoPDF)
            ->saveAs($path);

        if (!$retorno) {
            return $path;
        }

        if (is_file($path)) {

            // Set up PDF headers
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="'.'/LNDSistemas-M'.$model->numero.'.pdf'.'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($path));
            header('Accept-Ranges: bytes');

            // Retorna arquivo PDF
            return readfile($path);
        } else {
            // Retorna arquivo PHP
            return $conteudoPDF;
        }

        return $this->render('print',
                [
                'model' => $model,
        ]);
    }

    protected function getDocs($id)
    {
        $fatura = $this->findModel($id);
        if ($fatura->tipo == 'MINUTA') {
            return $this->getMinutas($id);
        } else {
            return $this->getCtes($id);
        }
    }

    protected function getMinutas($id)
    {
        $fatura       = $this->findModel($id);
        $modelCliente = new Clientes();
        $minutas      = $this->findModelDocs($id);
        $basicos      = new Basicos();

        $retorno = [];

        $i = 0;

        foreach ($minutas as $minuta) {

            $remetente           = $modelCliente->retornaCliente($minuta->minuta->remetente);
            $destinatario        = $modelCliente->retornaCliente($minuta->minuta->destinatario);
            $valornf             = explode('|', $minuta->minuta->notasvalor);
            $volumesnf           = explode('|', $minuta->minuta->notasvolumes);
            $notasvalor          = array_sum($valornf);
            $notasvolumes        = array_sum($volumesnf);
            $peso                = ($minuta->minuta->pesoreal > $minuta->minuta->pesocubado)
                    ? $minuta->minuta->pesoreal : $minuta->minuta->pesocubado;
            $totalpeso[]         = $peso;
            $totalnotasvalor[]   = $notasvalor;
            $totalnotasvolumes[] = $notasvolumes;
            $totalfrete[]        = $minuta->minuta->fretetotal;

            $retorno['embarques'][$i]['numero']       = $minuta->minuta->numero;
            $retorno['embarques'][$i]['remetente']    = $remetente->nome;
            $retorno['embarques'][$i]['destinatario'] = $destinatario->nome;
            $retorno['embarques'][$i]['emissao']      = $basicos->formataData('print',
                $minuta->minuta->cridt);
            $retorno['embarques'][$i]['notasnumero']  = $minuta->minuta->notasnumero;
            $retorno['embarques'][$i]['notasvalor']   = $notasvalor;
            $retorno['embarques'][$i]['peso']         = $peso;
            $retorno['embarques'][$i]['notasvolumes'] = $notasvolumes;
            $retorno['embarques'][$i]['fretetotal']   = $minuta->minuta->fretetotal;

            $i++;
        }

        $retorno['total']['embarques']    = $i;
        $retorno['total']['peso']         = array_sum($totalpeso);
        $retorno['total']['notasvalor']   = array_sum($totalnotasvalor);
        $retorno['total']['notasvolumes'] = array_sum($totalnotasvolumes);
        $retorno['total']['frete']        = array_sum($totalfrete);

//        Yii::$app->response->format = 'json';
//        echo '<pre>';
        return $retorno;
    }

    protected function getCtes($id)
    {
        $fatura       = $this->findModel($id);
        $modelCliente = new Clientes();
        $ctes         = $this->findModelDocs($id);
        $basicos      = new Basicos();

        $retorno = [];

        $i = 0;

        foreach ($ctes as $cte) {

            $peso = ($cte->cte->pesoreal > $cte->cte->pesocubado) ? $cte->cte->pesoreal
                    : $cte->cte->pesocubado;

            $totalpeso[]         = $peso;
            $totalnotasvalor[]   = $cte->cte->notasvalor;
            $totalnotasvolumes[] = $cte->cte->notasvolumes;
            $totalfrete[]        = $cte->cte->vtprest;

            $retorno['embarques'][$i]['numero']       = $cte->cte->numero;
            $retorno['embarques'][$i]['remetente']    = $cte->cte->cteRemetente->nome;
            $retorno['embarques'][$i]['destinatario'] = $cte->cte->cteDestinatario->nome;
            $retorno['embarques'][$i]['emissao']      = $basicos->formataData('print',
                $cte->cte->cridt);
            $retorno['embarques'][$i]['notasnumero']  = $cte->cte->notaChave;
            $retorno['embarques'][$i]['notasvalor']   = $cte->cte->notasvalor;
            $retorno['embarques'][$i]['peso']         = $peso;
            $retorno['embarques'][$i]['notasvolumes'] = $cte->cte->notasvolumes;
            $retorno['embarques'][$i]['fretetotal']   = $cte->cte->vtprest;

            $i++;
        }

        $retorno['total']['embarques']    = $i;
        $retorno['total']['peso']         = array_sum($totalpeso);
        $retorno['total']['notasvalor']   = array_sum($totalnotasvalor);
        $retorno['total']['notasvolumes'] = array_sum($totalnotasvolumes);
        $retorno['total']['frete']        = array_sum($totalfrete);

//        Yii::$app->response->format = 'json';
//        echo '<pre>';
        return $retorno;
    }

    public function actionSend($id)
    {

        // Modelo da Fatura
        $model = $this->findModel($id);

        if (!\Yii::$app->request->isAjax) {

            // Email dos envolvidos
            $envolvidos = new Clientes();
            $sacado     = $envolvidos->getEmail($model->sacado);

            return $this->render('send',
                    [
                    'model' => $model,
                    'sacado' => $sacado,
            ]);
        } else {

            // Cria o arquivo PDF para anexo
            $anexoPDF = $this->actionPrint($id, false);

            // Verifica se o arquivo existe
            if (!is_file($anexoPDF)) {
                return 'Anexo não encontrado!';
            } else {

                // Parametros passados por POST (ajax)
                $EmailDestinatario = explode(',',
                    Yii::$app->request->get('emails'));

                // Título do Email
                $titulo = 'LND Sistemas | '.\Yii::$app->user->identity['empresa'].' - Fatura '.$model->numero;

                $dados['sacado'] = $model->sacado;
                $dados['numero'] = $model->numero;

                $EnviaEmail = new EnviaEmail();
                $Envia      = $EnviaEmail->EnviarFatura($EmailDestinatario,
                    $titulo, $anexoPDF, $dados);

                return $Envia;
            }
        }
    }

    public function actionGrid()
    {
        $searchModel  = new MinutasSearch();
        $dataProvider = $searchModel->searchMinutas(Yii::$app->request->queryParams);

        return $this->renderPartial('_documentos',
                [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    protected function getNumero()
    {
        $model = new Fatura();
        $last  = $model->getLastId();

        return $last;
    }

    /**
     * Finds the Fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fatura::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelDocs($id)
    {
        if (($modelDocs = Documentos::findAll(['fatura_id' => $id])) !== null) {
            return $modelDocs;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelFinanceiro($id)
    {
        if (($modelFinanceiro = Financeiro::findOne(['fatura' => $id])) !== null) {
            return $modelFinanceiro;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}