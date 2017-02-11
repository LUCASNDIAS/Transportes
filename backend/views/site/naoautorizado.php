<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$name = 'Acesso negado';

$this->title = $name;
?>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?=$name;?></h3>

            <p>
                Voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar esta funcionalidade.
                Entre em contato caso voc&ecirc; acredite que seja um erro do servidor.
                Enquanto isso, voc&ecirc; pode <a href='<?= Yii::$app->homeUrl ?>'>retornar para o Sistema</a>.
            </p>

        </div>
    </div>

</section>
