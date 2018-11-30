<?php

namespace backend\modules\fatura\controllers;

use backend\modules\fatura\models\BoletoRegistro;
use backend\modules\fatura\models\FaturaBoleto;
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
class BoletoController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'teste'],
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

    public function actionIndex()
    {
        return $this->render('boleto');
    }

    public function actionTeste($id)
    {
        $configJson = Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json';
        $boletoRegistro = new BoletoRegistro($configJson);
        $modelBoleto = $this->findModel($id);
        if ($modelBoleto->status != 'REGISTRADO') {
            $arquivo = $boletoRegistro->criaRemessa($modelBoleto);
            $assinatura = $boletoRegistro->assinaRemessa($arquivo);
            $envio = $boletoRegistro->solicitaRegistro($assinatura, $modelBoleto);

            var_dump($envio);
        } else {
            return 'Já registrado';
        }
    }

    /**
     * Finds the FaturaBoleto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FaturaBoleto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FaturaBoleto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
