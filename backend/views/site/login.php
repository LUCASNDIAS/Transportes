<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Entrar';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

//echo password_hash('loggica',PASSWORD_BCRYPT);

?>
<video autoplay loop poster="polina.jpg" class="bg_video">
    <source src="/Transportes/web/videos/bg.webm" type="video/webm">
    <source src="/Transportes/backend/web/videos/hero_ambient.mp4" type="video/mp4">
</video>

<div class="login-box">
    <div class="login-logo">
    	<?= Html::a('<b>Gerador</b> Fiscal',
                    Yii::$app->urlManagerFrontend->createUrl('portal/')) ?>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Faça login para acessar o Sistema</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('Usuário')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('Senha')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>
    
        <div class="row"><p>&nbsp;</p></div>

        <div class="row">
            <div class="col-xs-6">
                <?= Html::a(
                    'Esqueci a senha',
                    Yii::$app->urlManagerFrontend->createUrl('/portal#contact'),
                    ['data-method' => 'get', 'class' => 'btn btn-default btn-flat']
                ) ?>
            </div>
            <div class="col-xs-6" style="text-align: right;">
                <?= Html::a(
                    'Solicitar acesso',
                    Yii::$app->urlManagerFrontend->createUrl('/portal#contact'),
                    ['data-method' => 'get', 'class' => 'btn btn-success btn-flat']
                ) ?>
            </div>
        </div>

        </p>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
