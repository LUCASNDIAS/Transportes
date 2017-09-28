<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\commands;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Basicos
{

    /**
     * Verifica permissões
     *
     * @param string $required A permissão requerida
     * @param array $user_permissions As permissões do usuário
     * @final
     */
    public function check_permissions(
    $required = 'any', $user_permissions = array('any')
    )
    {
        if (!is_array($user_permissions)) {
            return false;
        }

        // Se o usuário não tiver permissão
        if (!in_array($required, $user_permissions)) {
            // Retorna falso
            return false;
        } else {
            return true;
        }
    }

    /**
     * Altera as datas para visualização e para salvar
     * @param string $para Motivo da alteração (db ou ver)
     * @param unknownst string
     */
    public function formataData($para = 'db', $data)
    {
        if ($data !== null) {
            if ($para == 'db') {
                $sep_antes = '/';
                $sep_novo  = '-';
            } else {
                $sep_antes = '-';
                $sep_novo  = '/';
            }

            $exp       = explode($sep_antes, $data);
            $nova_data = $exp[2].$sep_novo.$exp[1].$sep_novo.$exp[0];
            return $nova_data;
        } else {
            return null;
        }
    }
}