<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">GRD</span><span class="logo-lg">' . Yii::$app->params['sistemaNome'] . '</span>', Yii::$app->homeUrl, ['class' => 'logo'])?>

    <nav class="navbar navbar-static-top" role="navigation">

		<a href="#" class="sidebar-toggle" data-toggle="offcanvas"
			role="button"> <span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">

			<ul class="nav navbar-nav">


				<!-- Messages: style can be found in dropdown.less-->
				<li class="dropdown messages-menu"><a href="#"
					class="dropdown-toggle" data-toggle="dropdown"> <i
						class="fa fa-envelope-o"></i> <span id="msgNovas" class="label label-success">0</span>
				</a>
					<ul class="dropdown-menu">
						<li class="header" id="msgNovastxt">Você não tem mensagens novas.</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu" id="menuTopo">
								<li>
									<!-- start message --> <a href="#">
										<div class="pull-left">
											<img src="<?= $directoryAsset ?>/img/user2-160x160.jpg"
												class="img-circle" alt="User Image" />
										</div>
										<h4>
											Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small>
										</h4>
										<p>Why not buy a new awesome theme?</p>
								</a>
								</li>
								<!-- end message -->
							</ul>
						</li>
						<li class="footer"><a href="#">Ver todas</a></li>
					</ul></li>
		
				<li class="dropdown user user-menu"><a href="#"
					class="dropdown-toggle" data-toggle="dropdown">
					<?php echo Html::img(Yii::$app->user->identity['foto'], 
							['class'=>'user-image',
							'alt'=>Yii::$app->user->identity['apelido']]);?> 
							<span class="hidden-xs">
								<?= Yii::$app->user->identity['nome']; ?>
							</span>
				</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
						<?php echo Html::img(Yii::$app->user->identity['foto'], 
							['class'=>'img-circle',
							'alt'=>Yii::$app->user->identity['apelido']]);?>
							<p>
                                <?= Yii::$app->user->identity['nome']; ?>
                                <small>
                                <?php
																																
								if (Yii::$app->user->can('admSite')) {
									echo "-- Administrador --"; 
								} else {
									echo '-- Usuário Padrão --';
								}?>
</small>
							</p></li>
						<!-- Menu Body -->
						<!--
						<li class="user-body">
							<div class="col-xs-4 text-center">
								<a href="#"></a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#"></a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#"></a>
							</div>
						</li>
						-->
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<?= Html::a(
										'Dados',
										'@web/clientes/listar?cnpj='.Yii::$app->user->identity['cnpj'],
										['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
										)?>
							</div>
							<div class="pull-right">
                                <?= Html::a(
                                    'Sair',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
						</li>
					</ul></li>
				
				<?php if (Yii::$app->user->can('admLND')) { ?>
				<!-- User Account: style can be found in dropdown.less -->
				<li>
					<a href="#" data-toggle="control-sidebar">
						<i class="fa fa-gears"></i>
					</a>				
				</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
</header>
