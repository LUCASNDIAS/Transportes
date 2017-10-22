<?php

namespace backend\models;

use Yii;
use backend\modules\clientes\models\Clientes;

class EnviaEmail extends \yii\db\ActiveRecord {

    public $from = 'lndsistemas@lndsistemas.com.br';

    public function Enviar($para, $assunto, $anexo, $dados, $tipo = 'minuta') {

        $clientes = new Clientes();

        $mensagemEmail = "Senhor Cliente,<br/><br/>Segue resumo da ". $tipo ." nº ";
        $mensagemEmail .= $dados['numero'] . " emitida através da plataforma <a href='http://www.lndsistemas.com.br' target='_blank'>LND Sistemas</a>:";
        $mensagemEmail .= "<p>";
        $mensagemEmail .= "<br /><b>Envolvidos</b><br />Remetente: " . $dados['remetente'] . " - " . $clientes->getNome($dados['remetente']);
        $mensagemEmail .= "<br />Destinatário: " . $dados['destinatario'] . " - " . $clientes->getNome($dados['destinatario']);
        $mensagemEmail .= "<br />Tomador: " . $dados['consignatario'] . " - " . $clientes->getNome($dados['consignatario']);
        $mensagemEmail .= "<br /><p>Segue arquivo PDF para consulta completa.</p>";

        $enviar = Yii::$app->mailer->compose()
                ->setFrom($this->from)
                ->setTo($para)
                //->setTo('diasnlucas@gmail.com')
                ->setSubject($assunto)
                ->setTextBody('Plain text content')
                ->setHtmlBody($mensagemEmail)
                ->attach($anexo)
                ->send();

        Yii::$app->response->format = 'json';

        if ($enviar) {
            $retorno['status'] = true;
            $retorno['msg'] = 'Email Enviado';
            $retorno['class'] = 'alert alert-success';
            $retorno['icone'] = 'icon fa fa-check';
        } else {
            $retorno['status'] = false;
            $retorno['msg'] = 'Erro ao tentar enviar email.';
            $retorno['class'] = 'alert alert-danger';
            $retorno['icone'] = 'icon fa fa-warning';
        }

        return $retorno;
    }

    public function EnviarFatura($para, $assunto, $anexo, $dados, $tipo = 'fatura') {

        $clientes = new Clientes();

        $mensagemEmail = "Senhor Cliente,<br/><br/>Segue fatura nº ";
        $mensagemEmail .= $dados['numero'] . " emitida através da plataforma <a href='http://www.lndsistemas.com.br' target='_blank'>LND Sistemas</a>:";
        $mensagemEmail .= "<p>";
        $mensagemEmail .= "<br /><b>Sacado</b><br />" . $dados['sacado'] . " - " . $clientes->getNome($dados['sacado']);
        $mensagemEmail .= "<br /><p>Segue arquivo PDF para conferência.</p>";

        $enviar = Yii::$app->mailer->compose()
                ->setFrom($this->from)
                ->setTo($para)
                //->setTo('diasnlucas@gmail.com')
                ->setSubject($assunto)
                ->setTextBody('Plain text content')
                ->setHtmlBody($mensagemEmail)
                ->attach($anexo)
                ->send();

        Yii::$app->response->format = 'json';

        if ($enviar) {
            $retorno['status'] = true;
            $retorno['msg'] = 'Email Enviado';
            $retorno['class'] = 'alert alert-success';
            $retorno['icone'] = 'icon fa fa-check';
        } else {
            $retorno['status'] = false;
            $retorno['msg'] = 'Erro ao tentar enviar email.';
            $retorno['class'] = 'alert alert-danger';
            $retorno['icone'] = 'icon fa fa-warning';
        }

        return $retorno;
    }

}
