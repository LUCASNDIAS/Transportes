<?php use yii\helpers\Html;?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            	<?php echo Html::img('@web/img/user.jpg', ['class'=>'img-circle']);?>
            </div>
            <div class="pull-left info">
                <p><?php echo 'Teste left'; // $this->params['DadosUsuario']['nome']; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Busca..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    //['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    //['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Admin',
                        'icon' => 'fa fa-cog',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'], 'visible' => true],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Clientes',
                        'icon' => 'fa fa-user',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adcionar', 'icon' => 'fa fa-user-plus', 'url' => ['/clientes/create'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/clientes'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Cotação',
                        'icon' => 'fa fa-file-text',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/cotacao/novo'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/cotacao/listar'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'CT-e',
                        'icon' => 'fa fa-file-code-o',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/cte/novo'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/cte/listar'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Faturas',
                        'icon' => 'fa fa-money',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Gerar (CTe)', 'icon' => 'fa fa-plus-square-o', 'url' => ['/fatura/novo', 'tipo' => 'cte'], 'visible' => true],
                            ['label' => 'Gerar (Minuta)', 'icon' => 'fa fa-plus-square', 'url' => ['/fatura/novo', 'tipo' => 'minuta'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/fatura/listar'], 'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Financeiro',
                        'icon' => 'fa fa-usd',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Pagar', 'icon' => 'fa fa-hand-o-down', 'url' => '#', 'visible' => true, 'items' => [
                                ['label' => 'Adcionar', 'icon' => 'fa fa-plus-square-o', 'url' => ['/financeiro/novo', 'tipo' => 'pagar'], 'visible' => true],
                                ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/financeiro/listar', 'tipo' => 'pagar'], 'visible' => true],
                                ],
                            ],
                            ['label' => 'Receber', 'icon' => 'fa fa-hand-o-up', 'url' => '#', 'visible' => true, 'items' => [
                                ['label' => 'Adcionar', 'icon' => 'fa fa-plus-square-o', 'url' => ['/financeiro/novo', 'tipo' => 'receber'], 'visible' => true],
                                ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/financeiro/listar', 'tipo' => 'receber'], 'visible' => true],
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Frota',
                        'icon' => 'fa fa-truck',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Veiculos', 'icon' => 'fa fa-car', 'url' => '#', 'visible' => true, 'items' => [
                                ['label' => 'Adcionar', 'icon' => 'fa fa-plus', 'url' => ['/frota/novo', 'tipo' => 'veiculo'], 'visible' => true],
                                ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/frota/listar', 'tipo' => 'veiculo'], 'visible' => true],
                                ],
                            ],
                            ['label' => 'Manutencao', 'icon' => 'fa fa-wrench', 'url' => ['/frota/manutencao'], 'visible' => true,],
                        ],
                    ],
                    [
                        'label' => 'Manifesto',
                        'icon' => 'fa fa-files-o',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/mdfe/novo'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/mdfe/listar'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Minutas',
                        'icon' => 'fa fa-newspaper-o',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/minuta/novo'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/minuta/listar'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Ordem de Coleta',
                        'icon' => 'fa fa-share-square-o',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/ordem/novo'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/ordem/listar'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Tabelas',
                        'icon' => 'fa fa-table',
                        'url' => '#',
                        'visible' => true,
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/tabela/novo'], 'visible' => true],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/tabela/listar'],'visible' => true],
                        ],
                    ],
                    [
                        'label' => 'Relatorios',
                        'icon' => 'fa fa-bar-chart',
                        'url' => ['/relatorio/novo'],
                        'visible' => true,
                    ],
                ],

            ]
        ) ?>

    </section>

</aside>
