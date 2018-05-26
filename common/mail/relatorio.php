<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 23/05/18
 * Time: 23:40
 */

use yii\helpers\Html;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Relatório</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 20px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="720"
                   style="border: 1px solid #cccccc;">
                <tr>
                    <td align="center" bgcolor="#797999" style="padding: 20px 0 10px 0;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="25%" style="padding: 0 20px 0 20px;"><img
                                            src="https://geradorfiscal.com.br/Transportes/backend/web/img/sistema/gerador-logo.png"
                                            alt="Gerador Fiscal" height="120" style="display: block;"/></td>
                                <td width="60%"
                                    style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                    <b><h2>Gerador Fiscal &reg;</h2></b>
                                    <p>Sua transportadora na direção certa.</p>
                                    <p><a href="https://geradorfiscal.com.br/" target="_blank" style="color: #ffffff">https://geradorfiscal.com.br/</a>
                                    </p>
                                </td>
                                <td width="15%"
                                    style="color: #e7e7e7; font-family: Arial, sans-serif; font-size: 14px; text-align: center;">
                                    <b>RELATÓRIO</b><br><br>
                                    <b><?= date('d/m/Y'); ?><br>
                                        <?= date('H:i'); ?></b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>Relatório Financeiro</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Boa tarde, <b><?= $usuario['empresa']; ?></b><br><br>Verificamos que os seguintes
                                    lançamentos merecem uma atenção especial pois ou
                                    já estão vencidos ou faltam até 3 dias para o vencimento. Em caso de dúvidas, acesse
                                    o sistema e confira: <a href="https://geradorfiscal.com.br/" target="_blank">Gerador
                                        Fiscal</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                           style="text-align: center; border: 1px solid #cccccc;">
                                        <tr>
                                            <td style="background-color: #797999; color: #ffffff; padding: 10px 10px 10px 10px; font-size: 15px;">
                                                Registros de Receitas
                                            </td>
                                        </tr>
                                        <?php
                                        if (empty($receitas)) {
                                            echo '<tr><td>Nenhum Registro encontrado</td></tr>';
                                        } else {
                                        ?>
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="1" width="100%"
                                                       style="font-size: 12px;">
                                                    <tr style="background-color: #111111; color: #ffffff; font-size: 12px;">
                                                        <td style="padding: 5px 5px 5px 5px;">Vencimento</td>
                                                        <td>Descrição</td>
                                                        <td>Sacado</td>
                                                        <td>Valor</td>
                                                        <td>Status</td>
                                                    </tr>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($receitas as $receita) {
                                                        $estilo1 = 'style="background-color: #888888; color: #ffffff; font-size: 13px;"';
                                                        $estilo2 = 'style="background-color: #555555; color: #ffffff; font-size: 13px;"';
                                                        $estilo3 = 'style="background-color: #ff5454"';
                                                        $estilo4 = 'style="background-color: #60a761"';
                                                        $tr = ($i==0) ? $estilo1 : $estilo2;
                                                        $td = ($receita['status'] == 'VENCIDO') ? $estilo3 : $estilo4;
                                                        ?>
                                                        <tr <?=$tr;?>>
                                                            <td style="padding: 2px 2px 2px 2px;"><?=$receita['vencimento'];?></td>
                                                            <td><?=$receita['descricao'];?></td>
                                                            <td><?=$receita['sacado'];?></td>
                                                            <td><?=$receita['valor'];?></td>
                                                            <td <?=$td;?>><?=$receita['status'];?></td>
                                                        </tr>
                                                        <?php
                                                        if ($i==1){
                                                            $i--;
                                                        } else {
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                           style="text-align: center; border: 1px solid #cccccc;">
                                        <tr>
                                            <td style="background-color: #797999; color: #ffffff; padding: 10px 10px 10px 10px; font-size: 15px;">
                                                Registros de Despesas
                                            </td>
                                        </tr>
                                        <?php
                                        if (empty($despesas)) {
                                            echo '<tr><td>Nenhum Registro encontrado</td></tr>';
                                        } else {
                                            ?>
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="1" width="100%"
                                                           style="font-size: 12px;">
                                                        <tr style="background-color: #111111; color: #ffffff; font-size: 12px;">
                                                            <td style="padding: 5px 5px 5px 5px;">Vencimento</td>
                                                            <td>Descrição</td>
                                                            <td>Sacado</td>
                                                            <td>Valor</td>
                                                            <td>Status</td>
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($despesas as $despesa) {
                                                            $estilo1 = 'style="background-color: #888888; color: #ffffff; font-size: 13px;"';
                                                            $estilo2 = 'style="background-color: #555555; color: #ffffff; font-size: 13px;"';
                                                            $estilo3 = 'style="background-color: #ff5454"';
                                                            $estilo4 = 'style="background-color: #60a761"';
                                                            $tr = ($i==0) ? $estilo1 : $estilo2;
                                                            $td = ($despesa['status'] == 'VENCIDO') ? $estilo3 : $estilo4;
                                                            ?>
                                                            <tr <?=$tr;?>>
                                                                <td style="padding: 2px 2px 2px 2px;"><?=$despesa['vencimento'];?></td>
                                                                <td><?=$despesa['descricao'];?></td>
                                                                <td><?=$despesa['sacado'];?></td>
                                                                <td><?=$despesa['valor'];?></td>
                                                                <td <?=$td;?>><?=$despesa['status'];?></td>
                                                            </tr>
                                                            <?php
                                                            if ($i==1){
                                                                $i--;
                                                            } else {
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td width="260" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td>
                                                            <img src="https://geradorfiscal.com.br/Transportes/backend/web/img/sistema/relatorio.png"
                                                                 alt="" width="100%" height="140"
                                                                 style="display: block;"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 25px 0 0 0;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            Acessando o sistema, é possível gerar este e outros
                                                            relatórios
                                                            referentes aos seus serviços.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="260" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td>
                                                            <img src="https://geradorfiscal.com.br/Transportes/backend/web/img/sistema/inicial.png"
                                                                 alt="" width="100%" height="140"
                                                                 style="display: block;"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            Fique ligado nas atualizações de versões e novidades da
                                                            SEFAZ do seu estado.
                                                            Acesse nosso portal. Envie sugestões.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                    <b>Gerador Fiscal &reg; - 2018</b><br/>
                                    Sua transportadora na direção certa.
                                </td>
                                <td align="right">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <a href="http://www.twitter.com/">
                                                    <img src="https://geradorfiscal.com.br/Transportes/backend/web/img/sistema/twitter.png"
                                                         alt="Twitter" width="38" height="38"
                                                         style="display: block;" border="0"/>
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td>
                                                <a href="http://www.twitter.com/">
                                                    <img src="https://geradorfiscal.com.br/Transportes/backend/web/img/sistema/face.png"
                                                         alt="Facebook" width="38" height="38"
                                                         style="display: block;" border="0"/>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
