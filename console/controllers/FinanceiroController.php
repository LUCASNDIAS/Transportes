<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use console\models\ConsoleFinanceiro;
use yii\base\InvalidParamException;

/**
 * Classe para Cron do Financeiro
 * @author Lucas Dias
 *
 */
class FinanceiroController extends Controller
{
    /**
     * Método para atualizar status das contas (pagar / receber)
     * @return string
     */
    public function actionAtualiza()
    {
        $model = new ConsoleFinanceiro();
        return $model->atualizaStatus();
    }

    public function actionNotifica()
    {
        $model = new ConsoleFinanceiro();
        return var_dump($model->notificaStatus());
    }
}