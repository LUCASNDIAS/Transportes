<?php

namespace console\models;

use backend\modules\financeiro\models\Financeiro;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 23/05/18
 * Time: 10:28
 */
class ConsoleFinanceiro
{
    /**
     * Atualiza o status de todos os registros do financeiro (não pagos/recebidos)
     * @return string
     */
    public function atualizaStatus()
    {
        $atualiza = $this->getContas();
        $hoje = date('Y-m-d');

        $retorno = '';

        foreach ($atualiza as $financeiro) {
            $registro = $this->findRegistro($financeiro->id);
            if ($hoje >= $registro->vencimento) {
                $registro->status = 'VENCIDO';
            } else {
                $registro->status = 'A VENCER';
            }

            $registro->save(false);

            $retorno[$registro->id] = $registro->status;

            unset($registro);
        }
        return $retorno;
    }

    public function notificaStatus()
    {
        $email = new Email();
        $usuarios = $this->getUsuarios();
        foreach ($usuarios as $usuario) {
            $registros = $this->getNotifica($usuario['cnpj']);
            if (!empty($registros)){
                $separado = ArrayHelper::index($registros, null, 'tipo');
                $retorno[] = $email->criaEmail($separado, $usuario);
            }
        }

        return (isset($retorno)) ? $retorno : 'Nada a se enviar';
    }

    protected function getContas()
    {
        $financeiro = Financeiro::find()
            ->where([
                '!=', 'status', 'PAGO'
            ])
            ->all();
        return $financeiro;
    }

    protected function findRegistro($id)
    {
        $atual = Financeiro::findOne(['id' => $id]);
        return $atual;
    }

    protected function getNotifica($dono)
    {
        $hoje = date('Y-m-d');
        $intervalo = date('Y-m-d', strtotime('+3 days'));

        $sql = "SELECT f.vencimento, f.descricao, c.nome as sacado, f.valor, f.status, f.tipo FROM financeiro f
                INNER JOIN clientes c on f.sacado = c.cnpj
                WHERE f.dono = $dono
                AND (f.status = 'VENCIDO' OR
                (f.status != 'PAGO' AND vencimento BETWEEN $hoje AND $intervalo))";

        $query = Yii::$app->db->createCommand($sql)
            ->queryAll();

        return $query;
    }

    protected function getUsuarios()
    {
        $sql = "select distinct u.cnpj, c3.email, u.empresa from usuarios u
                inner join clientes c on c.cnpj = u.cnpj
                inner join clientes_contatos c3 on c.id = c3.clientes_id
                where c3.email != ''";

        $query = Yii::$app->db->createCommand($sql)
            ->queryAll();

        return $query;
    }
}