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
	
	// Telefones
	var SPMaskBehavior = function (val) {
		  return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
		},
		spOptions = {
		  onKeyPress: function(val, e, field, options) {
		      field.mask(SPMaskBehavior.apply({}, arguments), options);
		    }
		};
	$('.telefone').mask(SPMaskBehavior, spOptions);
	$('.cep').mask('00000-000');
	
	// Passa todos os valores de input para maiusculo removendo acentos
	$('input, select, textarea').on('blur',function(){
		//var strMaiuscula = $(this).val().toUpperCase();
		//$(this).val(strMaiuscula);
		rm_acentos_caps($(this));
	});
	
	$("#clientes-nav").tab();
	$("#clientes-nome").focus();
	
	// Escreve isento na Inscrição estadual
	$("#clientes-ie").on('blur', function(){
		var InscEst = $(this);
		
		if(InscEst.val() == ''){
			InscEst.val('ISENTO');
		}
	});
	
	// Validar dados
		
	// Adiciona nova linha com dados de fomulário
	$(".adicionarCampo").click(function (e) {
		
        e.preventDefault();
        
        var duplicarPrimeiro = 'div.' + $(this).attr('id') + ':first';
        var contarTodos = $('div.' + $(this).attr('id')).length;
        var verificarUltimo = 'div.' + $(this).attr('id') + ':last';
        var novaIDresp = 'clientes-responsavel'+contarTodos;
        var novaIDtel = 'clientes-telefone'+contarTodos;
        var novaIDemail = 'clientes-email'+contarTodos;
        
        novoCampo = $(duplicarPrimeiro).clone(true);
        novoCampo.find("input").removeClass("has-success");
        novoCampo.find("#clientes-responsavel0").attr("id", novaIDresp);
        novoCampo.find("#clientes-telefone0").attr("id", novaIDtel);
        novoCampo.find("#clientes-email0").attr("id", novaIDemail);
        novoCampo.insertAfter(verificarUltimo);
        
        // Remove os valores dos novos campos
        var novoIDresp = '#' + novaIDresp;
        var novoIDtel = '#' + novaIDtel;
        var novoIDemail = '#' + novaIDemail;
        
        $(novoIDresp).val('');
        $(novoIDtel).val('');
        $(novoIDemail).val('');
        
        $('.telefone').mask(SPMaskBehavior, spOptions);

	});
	
	// Adiciona nova linha com dados de fomulário
	$(".adicionarTabelas").on('click',function (e) {
		
        e.preventDefault();
        
        var duplicarPrimeiro = 'div.' + $(this).attr('id') + ':first';
        var contarTodos = $('div.' + $(this).attr('id')).length;
        var verificarUltimo = 'div.' + $(this).attr('id') + ':last';
        var novaIDTabela = 'tabelaAuto'+contarTodos;
        
        novoCampo = $(duplicarPrimeiro).clone(true);
        novoCampo.find("input").removeClass("has-success");
        novoCampo.find("#tabelaAuto0").attr("id", novaIDTabela);
        novoCampo.insertAfter(verificarUltimo);
        
        // Remove os valores dos novos campos
        var novoIDTabela = '#' + novaIDTabela;
        
        $(novoIDTabela).val('');
        
        $(novoIDTabela).autocomplete({"source":TabelasSource});

	});
	
	function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#clientes-endrua").val("");
        $("#clientes-endbairro").val("");
        $("#clientes-endcid").val("");
        $("#clientes-enduf").val("");
        $("#clientes-endnro").val("");
        //$("#ibge").val("");
    }
    
    //Quando o campo cep perde o foco.
    $("#clientes-endcep").on('change', function() {
    	
    	// Zera o Formulario
    	limpa_formulário_cep();

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '').replace('-', '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#clientes-endrua").val("Aguarde")
                $("#clientes-endbairro").val("Aguarde")
                $("#clientes-endcid").val("Aguarde")
                $("#clientes-enduf").val("..")
                //$("#ibge").val("...")
            	
            	var dados = '';

                //Consulta o webservice viacep.com.br/
            	//$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
            	$.getJSON("//appservidor.com.br/webservice/cep?CEP="+ cep +"&saida=JSON&CALLBACK=alimenta_combobox", function(dados) {
                	
                    if (!("erro" in dados)) {
                    	
                        //Atualiza os campos com os valores da consulta.
                        $("#clientes-endrua").val(dados.logradouro_completo);
                        $("#clientes-endbairro").val(dados.bairro);
                        $("#clientes-endcid").val(dados.cidade);
                        $("#clientes-enduf").val(dados.uf_sigla);
                        $("#clientes-endnro").focus();
                        //$("#ibge").val(dados.ibge);
                        
                        //Retira os acentos do endereco
                        rm_acentos_caps($("#clientes-endrua"));
                        rm_acentos_caps($("#clientes-endbairro"));
                        rm_acentos_caps($("#clientes-endcid"));
                        rm_acentos_caps($("#clientes-enduf"));
                        rm_acentos_caps($("#clientes-endnro"));
                        
                        
                    } else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                //alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
    
    // Campos de Contato ( Responsavel, telefone e email )
    // Passar para o campos verdadeiro ao bind blur
    $("input[id^='clientes-responsavel'],input[id^='clientes-telefone'],input[id^='clientes-email']").bind("blur", function(){
    	
    	var email = false;
    	
    	// Verifica o Campo real do input atual!
    	if($(this).attr('name')=='telefone[]'){
    		var campoReal = '#telefones';
    		var selectTodos = "input[id^='clientes-telefone']";
    		var substituir = true;
    	} else if ($(this).attr('name')=='responsavel[]'){
    		var campoReal = '#responsaveis';
    		var selectTodos = "input[id^='clientes-responsavel']";
    		var substituir = false;
    	} else {
    		var campoReal = '#emails';
    		var selectTodos = "input[id^='clientes-email']";
    		var substituir = false;
    		email = true;
    	}
    	
    	var campoTemp = '';
    	
    	$( selectTodos ).each(function( index ) {
    		
    		campoTemp = campoTemp + '|' + $(this).val();
    		if (email) {
    			campoTemp = campoTemp.toLowerCase();
    		}
    		
        });
    	
    	$(campoReal).val(campoTemp);
    	
    });
    
    // Tabelas no campo Real
    $("input[id^='tabelaAuto']").bind('blur', function(){
    
    	var tabelas = '';
    	var controle = 0;
    	
    	for(i=0;i<=4;i++){
    		
    		var idAtual = '#tabelaAuto'+i;
	    	var campoAtual = $(idAtual).val();
	    	
	    	// Verifica se há algo preenchido
	    	if ( campoAtual != '' ) {
	    		
		    	// Pesquisa pelo separador
		    	var n = campoAtual.search(" | ");
		    	
		    	// separador ' | ' localizado
		    	if ( n != -1 ) {
		    		// Separa ID do Nome
		    		var separa = campoAtual.split(' | ');
		    		tabelas = tabelas+'|'+separa[0];
		    		controle++;
		    		
		    	} else {
		    		alert('Favor selecionar uma tabela válida.');
		    	}
		    	
		    	$("#tabelas").val(tabelas);
		    	
	    	} else {
	    		
	    	}
    	} 
    	
    	if ( controle == 0 ) {
    		$("#tabelas").val('');
    	}
    	
    });
    
    // Submit
    $("#submitCreate, #submitUpdate").click(function(e){
    	e.preventDefault();
    	var urlAtual = window.location.href;
    	var Formulario = $("#clientes-form").serialize();
    	var Confirma = Formulario + '&salvar=sim';
    	$.post( urlAtual, Confirma );
    });
    
});