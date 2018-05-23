<?php use yii\helpers\Html;?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            	<?php echo Html::img(Yii::$app->user->identity['foto'], ['class'=>'img-circle']);?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity['nome']; ?></p>

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
                        'visible' => Yii::$app->user->can('admLND'),
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'], 'visible' => Yii::$app->user->can('admLND')],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],'visible' => Yii::$app->user->can('admLND')],
                        	['label' => 'Update', 'icon' => 'fa fa-recycle', 'url' => ['/update/index'],'visible' => Yii::$app->user->can('admLND')],
                        	['label' => 'Mensagens', 'icon' => 'fa fa-envelope-o', 'url' => '#', 'visible' => Yii::$app->user->can('admLND'), 'items' => [
                        			['label' => 'Adcionar', 'icon' => 'fa fa-plus-square-o', 'url' => ['/mensagens/default/create'], 'visible' => Yii::$app->user->can('admLND')],
                        			['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/mensagens'], 'visible' => Yii::$app->user->can('admLND')],
                        		],
                        	],
                        ],
                    ],
                    [
                        'label' => 'Clientes',
                        'icon' => 'fa fa-user',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verClientes'),
                        'items' => [
                            ['label' => 'Adcionar', 'icon' => 'fa fa-user-plus', 'url' => ['/clientes/default/create'], 'visible' => Yii::$app->user->can('addClientes')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/clientes'],'visible' => Yii::$app->user->can('verClientes')],
                        ],
                    ],
                    [
                        'label' => 'Cotação',
                        'icon' => 'fa fa-file-text',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verCotacao'),
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/cotacao/default/create'], 'visible' => Yii::$app->user->can('addCotacao')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/cotacao'],'visible' => Yii::$app->user->can('verCotacao')],
                        ],
                    ],
                    [
                        'label' => 'CT-e',
                        'icon' => 'fa fa-file-code-o',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verCte'),
                        'items' => [
                            ['label' => 'Emitir', 'icon' => 'fa fa-plus', 'url' => ['/cte/default/create'], 'visible' => Yii::$app->user->can('addCte')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/cte'],'visible' => Yii::$app->user->can('verCte')],
                        ],
                    ],
//                    [
//                        'label' => 'Faturas',
//                        'icon' => 'fa fa-money',
//                        'url' => '#',
//                        'visible' => Yii::$app->user->can('verContas'),
//                        'items' => [
//                            ['label' => 'Gerar (CTe)', 'icon' => 'fa fa-plus-square-o', 'url' => ['/fatura/create', 'tipo' => 'cte'], 'visible' => Yii::$app->user->can('addContas')],
//                            ['label' => 'Gerar (Minuta)', 'icon' => 'fa fa-plus-square', 'url' => ['/fatura/create', 'tipo' => 'minuta'], 'visible' => Yii::$app->user->can('addContas')],
//                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/fatura'], 'visible' => Yii::$app->user->can('verContas')],
//                        ],
//                    ],
                    [
                        'label' => 'Financeiro',
                        'icon' => 'fa fa-usd',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verContas'),
                        'items' => [
                            ['label' => 'Despesas', 'icon' => 'fa fa-credit-card', 'url' => ['/financeiro', 't' => 'D'], 'visible' => Yii::$app->user->can('addContas')],
                            ['label' => 'Receitas', 'icon' => 'fa fa-euro', 'url' => ['/financeiro', 't' => 'R'], 'visible' => Yii::$app->user->can('addContas')],
                            ['label' => 'Faturas', 'icon' => 'fa fa-money', 'url' => ['/fatura'], 'visible' => Yii::$app->user->can('verContas')],
                        ],
                    ],
//                    [
//                        'label' => 'Financeiro',
//                        'icon' => 'fa fa-usd',
//                        'url' => '#',
//                        'visible' => Yii::$app->user->can('verContas'),
//                        'items' => [
//                            ['label' => 'Pagar', 'icon' => 'fa fa-hand-o-down', 'url' => '#', 'visible' => true, 'items' => [
//                                ['label' => 'Adcionar', 'icon' => 'fa fa-plus-square-o', 'url' => ['/financeiro/create', 'tipo' => 'pagar'], 'visible' => Yii::$app->user->can('addContas')],
//                                ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/financeiro', 'tipo' => 'pagar'], 'visible' => Yii::$app->user->can('verContas')],
//                                ],
//                            ],
//                            ['label' => 'Receber', 'icon' => 'fa fa-hand-o-up', 'url' => '#', 'visible' => true, 'items' => [
//                                ['label' => 'Adcionar', 'icon' => 'fa fa-plus-square-o', 'url' => ['/financeiro/create', 'tipo' => 'receber'], 'visible' => Yii::$app->user->can('addContas')],
//                                ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/financeiro', 'tipo' => 'receber'], 'visible' => Yii::$app->user->can('verContas')],
//                                ],
//                            ],
//                        ],
//                    ],
//                    [
//                        'label' => 'Frota',
//                        'icon' => 'fa fa-truck',
//                        'url' => '#',
//                        'visible' => Yii::$app->user->can('verFrota'),
//                        'items' => [
//                            ['label' => 'Veiculos', 'icon' => 'fa fa-car', 'url' => '#', 'visible' => true, 'items' => [
//                                ['label' => 'Adcionar', 'icon' => 'fa fa-plus', 'url' => ['/frota/create', 'tipo' => 'veiculo'], 'visible' => Yii::$app->user->can('addFrota')],
//                                ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/frota', 'tipo' => 'veiculo'], 'visible' => Yii::$app->user->can('verFrota')],
//                                ],
//                            ],
//                            ['label' => 'Manutencao', 'icon' => 'fa fa-wrench', 'url' => ['/frota/manutencao'], 'visible' => Yii::$app->user->can('verFrota'),],
//                        ],
//                    ],
                    [
                		'label' => 'Frota',
                		'icon' => 'fa fa-truck',
                		'url' => '#',
                		'visible' => Yii::$app->user->can('verFrota'),
                		'items' => [
                			['label' => 'Adcionar', 'icon' => 'fa fa-user-plus', 'url' => ['/veiculos/default/create'], 'visible' => Yii::$app->user->can('addFuncionarios')],
                			['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/veiculos'],'visible' => Yii::$app->user->can('verFuncionarios')],
                		]
                   	],
                	[
                		'label' => 'Funcionários',
                		'icon' => 'fa fa-user',
                		'url' => '#',
                		'visible' => Yii::$app->user->can('addFuncionarios'),
                		'items' => [
                			['label' => 'Adcionar', 'icon' => 'fa fa-user-plus', 'url' => ['/funcionarios/default/create'], 'visible' => Yii::$app->user->can('addFuncionarios')],
                			['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/funcionarios'],'visible' => Yii::$app->user->can('verFuncionarios')],
                		]
                   	],
                    [
                        'label' => 'Manifesto',
                        'icon' => 'fa fa-files-o',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verMdfe'),
                        'items' => [
                            ['label' => 'Emitir', 'icon' => 'fa fa-plus', 'url' => ['/mdfe/default/create'], 'visible' => Yii::$app->user->can('addMdfe')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/mdfe'],'visible' => Yii::$app->user->can('verMdfe')],
                        ],
                    ],
                    [
                        'label' => 'Minutas',
                        'icon' => 'fa fa-newspaper-o',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verMinutas'),
                        'items' => [
                            ['label' => 'Emitir', 'icon' => 'fa fa-plus', 'url' => ['/minutas/create'], 'visible' => Yii::$app->user->can('addMinutas')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/minutas'],'visible' => Yii::$app->user->can('verMinutas')],
                        ],
                    ],
                    [
                        'label' => 'Ordem de Coleta',
                        'icon' => 'fa fa-share-square-o',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verOC'),
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/ordemcoleta/default/create'], 'visible' => Yii::$app->user->can('addOC')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/ordemcoleta'],'visible' => Yii::$app->user->can('verOC')],
                        ],
                    ],
                    [
                        'label' => 'Tabelas',
                        'icon' => 'fa fa-table',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('verTabelas'),
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/tabelas/create'], 'visible' => Yii::$app->user->can('addTabelas')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/tabelas'],'visible' => Yii::$app->user->can('verTabelas')],
                        ],
                    ],
                    [
                        'label' => 'Seguro',
                        'icon' => 'fa fa-lock',
                        'url' => '#',
                        'visible' => Yii::$app->user->can('admin'),
                        'items' => [
                            ['label' => 'Adicionar', 'icon' => 'fa fa-plus', 'url' => ['/seguro/default/create'], 'visible' => Yii::$app->user->can('addTabelas')],
                            ['label' => 'Buscar', 'icon' => 'fa fa-search', 'url' => ['/seguro'],'visible' => Yii::$app->user->can('verTabelas')],
                        ],
                    ],
                    [
                        'label' => 'Relatorios',
                        'icon' => 'fa fa-bar-chart',
                        'url' => ['/relatorios'],
                        'visible' => Yii::$app->user->can('verRelatorios'),
                    ],
                ],

            ]
        ) ?>

    </section>

</aside>
