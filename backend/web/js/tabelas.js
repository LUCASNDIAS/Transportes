/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function(){
	
	// Esconder divs
	//$('.hide').show();
	
	// Função que remove acentos e caps formulario
	function rm_acentos_caps(campo){
		var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g,'a').replace(/[éèêẽÉÈÊẼ]/g,'e').replace(/[íìîĩÍÌÎĨ]/g,'i').replace(/[óòôõÓÒÔÕ]/g,'o').replace(/[úùûũüÚÙÛŨÜ]/g,'u').replace(/[çÇ]/g,'c').toUpperCase();
		campo.val(valor);
	}
	
	// Mascaras para formulários
	$('.dinheiro').maskMoney({
		thousands:'',
		decimal:'.',
		allowZero:true,
		affixesStay: false,
		prefix: 'R$ '
	});
	$('.obrig-din').maskMoney({
		thousands:'',
		decimal:'.',
		allowZero:false,
		affixesStay: false,
		prefix: 'R$ '
	});
	$('.porcento').maskMoney({
		thousands:'',
		decimal:'.',
		precision: 2,
		allowZero:true,
		suffix: ' %',
		affixesStay: false
	});
	$('.obrig-peso').maskMoney({
		thousands:'',
		decimal:'.',
		precision: 2,
		allowZero:false,
		suffix: ' Kg',
		affixesStay: false
	});
	
	// Passa todos os valores de input para maiusculo removendo acentos
	$('input, select, textarea').on('blur',function(){
		rm_acentos_caps($(this));
	});
	
	$("#tabelas-nome").focus();
	
	// Escreve 0.00 nos campos de valor em branco
	$(".dinheiro").on('blur', function(){
		
		if($(this).val() == ''){
			$(this).val('0.00');
		}
		
	});
	
	// Falta colocar isto pra TabelasSearch[valorminimo], etc
	$(document).on("click","input[name^='TabelasSearch[valorminimo]'],input[name^='TabelasSearch[pesominimo]'],input[name^='TabelasSearch[excedente]']", function(){
		$(this).maskMoney({
			thousands:'',
			decimal:'.',
			precision: 2,
			allowZero:false,
		});
	});
    
});