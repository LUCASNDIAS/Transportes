<?php

namespace console\models;

use backend\modules\financeiro\models\Financeiro;
use Yii;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 23/05/18
 * Time: 10:28
 */
class Email
{
    public $from = 'financeiro@geradorfiscal.com.br';

    public function criaEmail($dados, $usuario)
    {
        return $this->enviarEmail($dados, $usuario);
    }

    protected function enviarEmail($dados, $usuario)
    {

        $enviar = Yii::$app->mailer->compose('relatorio', [
            'receitas' => (isset($dados['R'])) ? $dados['R'] : [],
            'despesas' => (isset($dados['D'])) ? $dados['D'] : [],
            'usuario' => $usuario
        ])
            ->setFrom($this->from)
            ->setReplyTo($this->from)
            ->setTo([
                strtolower($usuario['email']),
                'diasnlucas@gmail.com'
            ])
            ->setSubject('Relatório - Financeiro')
            ->send();

        return $enviar;

    }


}