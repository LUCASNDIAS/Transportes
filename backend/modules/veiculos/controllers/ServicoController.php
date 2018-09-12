<?php

namespace backend\modules\veiculos\controllers;

use backend\modules\veiculos\models\Veiculos;
use backend\modules\veiculos\models\VeiculosServicoPagamento as Pagamento;
use backend\modules\veiculos\models\VeiculosServicoTipo;
use backend\base\Model;
use backend\commands\Basicos;
use backend\modules\financeiro\models\Financeiro;
use Yii;
use backend\modules\veiculos\models\VeiculosServico;
use backend\modules\veiculos\models\VeiculosServicoSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ServicoController implements the CRUD actions for VeiculosServico model.
 */
class ServicoController extends Controller
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
     * Lists all VeiculosServico models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VeiculosServicoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VeiculosServico model.
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
     * Creates a new VeiculosServico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tipo = 'S')
    {
        $basicos = new Basicos();

        $model = new VeiculosServico();
        $modelsPagamento = [new Pagamento()];

        $modelVeiculos = new Veiculos();
        $data = $modelVeiculos->autoComplete();

        $modelServicoTipo = new VeiculosServicoTipo();
        $tipos = $modelServicoTipo->findTipo($tipo);

        if ($model->load(Yii::$app->request->post())) {

            $modelsPagamento = Model::createMultiple(Pagamento::classname());
            Model::loadMultiple($modelsPagamento, Yii::$app->request->post());

            $valid = $model->validate();

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        $last_id = \Yii::$app->db->getLastInsertID();

                        foreach ($modelsPagamento as $modelPagamento) {

                            $despesa = new Financeiro();
                            $despesa->cridt = $model->cridt;
                            $despesa->criusu = $model->criusu;
                            $despesa->dono = $model->dono;
                            $despesa->nome = $model->local . ' - PARCELA: ' . $modelPagamento->parcela;
                            $despesa->descricao = 'FROTA - ' . $model->veiculo0->placa . ' - ' . $model->local;
                            $despesa->emissao = $model->cridt;
                            $despesa->vencimento = $basicos->formataData('db', $modelPagamento->vencimento);
                            $despesa->valor = $modelPagamento->valor;
                            $despesa->dtpgto = null;
                            $despesa->sacado = null;
                            $despesa->fatura = null;
                            $despesa->tipo = 'D';
                            $hoje = date('Y-m-d');
                            $despesa->status = ($hoje <= $despesa->vencimento) ? 'A VENCER' : 'VENCIDO';

                            $modelPagamento->vencimento = $basicos->formataData('db', $modelPagamento->vencimento);
                            $modelPagamento->financeiro = $despesa->save() ? $despesa->id : null;
                            $modelPagamento->servico = $last_id;

                            if (!($flag = $modelPagamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {

                    $transaction->rollBack();
                }

            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'data' => $data,
                'tipo_servico' => $tipo,
                'tipos' => $tipos,
                'modelsPagamento' => (empty($modelsPagamento)) ? [new VeiculosServicoPagamento]
                    : $modelsPagamento,
            ]);
        }
    }

    /**
     * Updates an existing VeiculosServico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $basicos = new Basicos();

        $modelVeiculos = new Veiculos();
        $data = $modelVeiculos->autoComplete();

        $modelServicoTipo = new VeiculosServicoTipo();
        $tipos = $modelServicoTipo->findTipo($model->tipo);

        $modelsPagamento = $model->pagamentoServico;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsPagamento, 'id', 'id');
            $modelsPagamento = Model::createMultiple(Pagamento::classname(),
                $modelsPagamento);
            Model::loadMultiple($modelsPagamento, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs,
                array_filter(ArrayHelper::map($modelsPagamento, 'id', 'id')));

            $deletedFin = ArrayHelper::map($modelsPagamento, 'financeiro', 'financeiro');

            // validate all models
            $valid = $model->validate();

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {

                        if (!empty($deletedIDs)) {
                            Pagamento::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsPagamento as $modelPagamento) {
                            $despesa = new Financeiro();
                            $despesa->cridt = $model->cridt;
                            $despesa->criusu = $model->criusu;
                            $despesa->dono = $model->dono;
                            $despesa->nome = $model->local . ' - PARCELA: ' . $modelPagamento->parcela;
                            $despesa->descricao = 'FROTA - ' . $model->veiculo0->placa . ' - ' . $model->local;
                            $despesa->emissao = $model->cridt;
                            $despesa->vencimento = $basicos->formataData('db', $modelPagamento->vencimento);
                            $despesa->valor = $modelPagamento->valor;
                            $despesa->dtpgto = null;
                            $despesa->sacado = null;
                            $despesa->fatura = null;
                            $despesa->tipo = 'D';
                            $hoje = date('Y-m-d');
                            $despesa->status = ($hoje <= $despesa->vencimento) ? 'A VENCER' : 'VENCIDO';

                            $modelPagamento->financeiro = $despesa->save() ? $despesa->id : null;
                            $modelPagamento->servico = $model->id;

                            if (!($flag = $modelPagamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                    }

                    if ($flag) {

                        $transaction->commit();

                        if (!empty($deletedFin)) {
                            Financeiro::deleteAll(['id' => $deletedFin]);
                        }

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {

                    $transaction->rollBack();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $model->data = $basicos->formataData('form', $model->data);
            $model->prox_data = $basicos->formataData('form', $model->prox_data);

            return $this->render('update', [
                'model' => $model,
                'data' => $data,
                'tipos' => $tipos,
                'modelsPagamento' => (empty($modelsPagamento)) ? [new Pagamento] : $modelsPagamento,
            ]);
        }
    }

    /**
     * Deletes an existing VeiculosServico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // Model de serviços
        $model = $this->findModel($id);

        // Model de Pagamento
        $modelsPagamento = $model->pagamentoServico;

        $delPag = ArrayHelper::map($modelsPagamento, 'id', 'id');
        $delFin = ArrayHelper::map($modelsPagamento, 'financeiro', 'financeiro');

        if (!empty($delPag)) {
            Pagamento::deleteAll(['id' => $delPag]);
        }

        if (!empty($delFin)) {
            Financeiro::deleteAll(['id' => $delFin]);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VeiculosServico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VeiculosServico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VeiculosServico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
