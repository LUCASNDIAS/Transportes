<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

//$name = "Not Found (#404)" ? "Não encontrado (#404)" : $name;

//$erro = ($message == "You are not allowed to perform this action.") ? "Permissão negada." : $message;

$this->title = $name;
?>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?=$name;?></h3>

            <p>
                <span class="text-red"><?= nl2br(Html::encode($erro)) ?></span>
            </p>

            <p>
                O erro acima ocorreu enquanto o servidor estava processando sua solicitação.
                Entre em contato caso você acredite que seja um erro do servidor.
                Enquanto isso, você pode <a href='<?= Yii::$app->homeUrl ?>'>retornar para o Sistema</a>.
            </p>

        </div>
    </div>

</section>
