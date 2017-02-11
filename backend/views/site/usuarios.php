<?php
use yii\widgets\LinkPager;
use yii\base\Widget;
?>
<h1>Usuarios</h1>

<ul>
<?php foreach ($usuarios as $usuario) : ?>
	<li><?=$usuario->nome; ?></li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination'=>$pagination]); ?>