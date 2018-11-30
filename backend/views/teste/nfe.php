<?php
use backend\assets\TesteAsset;

TesteAsset::register($this);

$url = file_get_contents('http://www.nfe.fazenda.gov.br/portal/consultaRecaptcha.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=');
echo $url;
?>
<div id="nfe">

</div>