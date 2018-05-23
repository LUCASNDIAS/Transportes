/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function(){
	
	// Função que remove acentos e caps formulario
	function rm_acentos_caps(campo){
		var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g,'a').replace(/[éèêẽÉÈÊẼ]/g,'e').replace(/[íìîĩÍÌÎĨ]/g,'i').replace(/[óòôõÓÒÔÕ]/g,'o').replace(/[úùûũüÚÙÛŨÜ]/g,'u').replace(/[çÇ]/g,'c').toUpperCase();
		campo.val(valor);
	}
	
	// Passa todos os valores de input para maiusculo removendo acentos
	$('input, select, textarea').on('blur',function(){
		//var strMaiuscula = $(this).val().toUpperCase();
		//$(this).val(strMaiuscula);
		rm_acentos_caps($(this));
	});
	
	$("#seguro-xseg").focus();
    
});