<?php

use yii\helpers\Html;
use backend\assets\ProfileAsset;

ProfileAsset::register($this);

$logo = '@web/img/usuarios/Logo-' . Yii::$app->user->identity['cnpj'] . '.jpg';
$endereco = $modelUsuario->endrua . ', ' . $modelUsuario->endnro . ' - ' .
    $modelUsuario->endbairro . ' / ' . $modelUsuario->endcid;
$pref_id = ($modelUsuario->clientesPrefs === null) ? '0' : $modelUsuario->clientesPrefs->id;
$check_financeiro = '';
$check_veiculos = '';

if ($pref_id != '0') {
    $check_financeiro = ($modelUsuario->clientesPrefs->financeiro == '1') ? 'checked' : '';
    $check_veiculos = ($modelUsuario->clientesPrefs->veiculos == '1') ? 'checked' : '';
}

?>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <?php echo Html::img(Yii::$app->user->identity['foto'], ['class' => 'profile-user-img img-responsive img-circle']); ?>

                    <h3 class="profile-username text-center">
                        <?= ucwords(strtolower(Yii::$app->user->identity['nome'])); ?>
                    </h3>

                    <p class="text-muted text-center">
                        Gerador Fiscal
                    </p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Clientes</b>
                            <a class="pull-right" id="ajaxclientes">
                                <i class="fa fa-spin fa-refresh"></i>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>CT-e</b>
                            <a class="pull-right" id="ajaxcte">
                                <i class="fa fa-spin fa-refresh"></i>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Faturas</b>
                            <a class="pull-right" id="ajaxfaturas">
                                <i class="fa fa-spin fa-refresh"></i>
                            </a>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-primary btn-block"><b>Trocar Senha</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Certificado</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-info-circle margin-r-5"></i> Status</strong>

                    <p class="text-muted" id="ajaxcertificado">
                        <i class="fa fa-spin fa-refresh"></i>
                    </p>

                    <hr>

                    <strong><i class="fa fa-calendar-check-o margin-r-5"></i> Validade</strong>

                    <p class="text-muted" id="ajaxvalidade">
                        <i class="fa fa-spin fa-refresh"></i>
                    </p>

                    <hr>

                    <p class="text-justify text-muted description">
                        O sistema usa o certificado digital do tipo A1 para assinaturas e troca
                        de arquivos com a SEFAZ.
                    </p>

                    <a href="#" class="btn btn-primary btn-block"><b>Atualizar Certificado</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#empresa" data-toggle="tab">Empresa</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="empresa">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <?= Html::img($logo, ['class' => 'img-circle img-bordered-sm']); ?>

                                <span class="username">
                                  <?= Html::a(Yii::$app->user->identity->empresa, ['/clientes/default/update', 'id' => $modelUsuario->id]); ?>
                                  <?= Html::a('<i class="fa fa-edit"></i>', ['/clientes/default/update', 'id' => $modelUsuario->id], ['class' => 'pull-right btn-box-tool']); ?>
                                </span>
                                <span class="description">
                                    CNPJ: <?= Yii::$app->user->identity->cnpj; ?>
                                </span>
                            </div>
                            <!-- /.user-block -->
                            <p>

                            <ul class="list-inline">
                                <li><span class="text-bold">Nome: </span> <?= Yii::$app->user->identity->empresa; ?>
                                </li>
                                <li><span class="text-bold">CNPJ: </span> <?= Yii::$app->user->identity->cnpj; ?></li>
                                <li><span class="text-bold">I.E.: </span> <?= $modelUsuario->ie; ?></li>
                                <li><span class="text-bold">RNTRC: </span> <?= Yii::$app->user->identity->rntrc; ?></li>
                            </ul>

                            <hr>

                            <ul class="list-inline">
                                <li>
                                    <span class="text-bold">Endereço: </span>
                                    <?= ucwords(strtolower($endereco)); ?>
                                </li>
                                <li>
                                    <span class="text-bold">CEP: </span>
                                    <?= $modelUsuario->endcep; ?>
                                </li>
                            </ul>

                            <hr>

                            <span class="text-bold text-blue">Contatos: </span>

                            <br/><br/>

                            <?php
                            foreach ($modelUsuario->clientesContatos as $clientesContato) {
                                ?>

                                <ul class="list-inline">
                                    <li>
                                        <span class="text-bold">Nome: </span>
                                        <?= ucwords(strtolower($clientesContato->nome)); ?>
                                    </li>
                                    <li>
                                        <span class="text-bold">Telefone: </span>
                                        <?= $clientesContato->telefone; ?>
                                    </li>
                                    <li>
                                        <span class="text-bold">E-mail: </span>
                                        <?= strtolower($clientesContato->email); ?>
                                    </li>
                                </ul>

                            <?php } ?>

                            </p>

                        </div>
                        <!-- /.post -->
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#preferencias" data-toggle="tab">Preferências</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="preferencias">
                        <!-- Post -->
                        <div class="post">
                            <p class="text-justify text-muted description">
                                Altere as funcionalidade de acordo com sua preferência. O tema escolhido
                                será alterado ao clicar em qualquer módulo do menu ou ao sair e acessar
                                novamente
                            </p>
                            <p>
                                <span class="text-bold">Cor do Tema:</span>
                            <ul class="list-inline">
                                <li>
                                    <button class="btn btn-primary tema" id="skin-blue">Azul</button>
                                </li>
                                <li>
                                    <button class="btn btn-danger tema" id="skin-red">Vermelho</button>
                                </li>
                                <li>
                                    <button class="btn bg-purple tema" id="skin-purple">Roxo</button>
                                </li>
                                <li>
                                    <button class="btn bg-yellow tema" id="skin-yellow">Laranja</button>
                                </li>
                                <li>
                                    <button class="btn btn-success tema" id="skin-green">Verde</button>
                                </li>
                                <li>Tema atual:
                                    <span id="tema-atual">
                                        <i class="fa fa-spin fa-refresh"></i>
                                    </span>
                                    <input type="text" name="tema" id="tema" class="hide">
                                </li>
                                <li class="pull-right">Novo Tema:
                                    <span id="tema-novo">
                                        Sem alteração!
                                    </span>
                                </li>
                            </ul>
                            </p>
                            <p>
                                <span class="text-bold">Receber informações financeiras?</span>
                            <div class="onoffswitch">
                                <input type="checkbox" value="1" name="financeiro" class="onoffswitch-checkbox"
                                       id="financeiro" <?= $check_financeiro; ?>>
                                <label class="onoffswitch-label" for="financeiro">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                            </p>

                            <p>
                                <span class="text-bold">Receber informações de veículos?</span>
                            <div class="onoffswitch">
                                <input type="checkbox" value="1" name="veiculos" class="onoffswitch-checkbox"
                                       id="veiculos" <?= $check_veiculos; ?>>
                                <label class="onoffswitch-label" for="veiculos">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                            </p>
                            <?= Html::input('text', 'pref-id', $pref_id, [
                                'class' => 'hide',
                                'id' => 'pref_id'
                            ]); ?>
                            <?= Html::input('text', 'cliente_id', $modelUsuario->id, [
                                'class' => 'hide',
                                'id' => 'cliente_id'
                            ]); ?>

                            <?= Html::button('Salvar', ['class' => 'btn btn-primary salvar']); ?>
                            <span class="text-bold" id="save-prefs"></span>

                        </div>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->