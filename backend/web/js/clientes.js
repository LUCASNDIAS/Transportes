/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    // Controle dos campos dinâmicos de contatos e tabelas
    jQuery(".dynamicform_wrapper").on("afterInsert", function (e, item) {
        jQuery(".dynamicform_wrapper .panel-title-contato").each(function (index) {
            jQuery(this).html("Contato: " + (index + 1));
            // Passa todos os valores de input para maiusculo removendo acentos
            $('input, select, textarea').on('blur', function () {
                rm_acentos_caps($(this));
            });
            $('.telefone').mask(SPMaskBehavior, spOptions);
        });
    });

    jQuery(".dynamicform_wrapper").on("afterDelete", function (e) {
        jQuery(".dynamicform_wrapper .panel-title-contato").each(function (index) {
            jQuery(this).html("Contato: " + (index + 1));
            // Passa todos os valores de input para maiusculo removendo acentos
            $('input, select, textarea').on('blur', function () {
                rm_acentos_caps($(this));
            });
            $('.telefone').mask(SPMaskBehavior, spOptions);
        });
    });

    jQuery(".dynamicform_wrapper_tab").on("afterInsert", function (e, item) {
        jQuery(".dynamicform_wrapper_tab .panel-title-tab").each(function (index) {
            jQuery(this).html("Tabela: " + (index + 1));
            // Get com as tabelas disponíveis
            $.get("/Transportes/backend/web/ajax/tabelascomp", function (data) {
                var tabelas = $.parseJSON(data);
                jQuery('#tabela-' + index + '-nome').autocomplete({"source": tabelas, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                        $('#tabelasclientes-' + index + '-tabela_id').val(ui.item.id); // Campo real do remetente
                        $('#tabelasclientes-' + index + '-tabela_id').focus();
                    }});
            });
        });
    });

    jQuery(".dynamicform_wrapper_tab").on("afterDelete", function (e) {
        jQuery(".dynamicform_wrapper_tab .panel-title-tab").each(function (index) {
            jQuery(this).html("Tabela: " + (index + 1));
            $.get("/Transportes/backend/web/ajax/tabelascomp", function (data) {
                var tabelas = $.parseJSON(data);
                jQuery('#tabela-' + index + '-nome').autocomplete({"source": tabelas, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                        $('#tabelasclientes-' + index + '-tabela_id').val(ui.item.id); // Campo real do remetente
                        $('#tabelasclientes-' + index + '-tabela_id').focus();
                    }});
            });
        });
    });

    // Função que remove acentos e caps formulario
    function rm_acentos_caps(campo) {
        var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
        campo.val(valor);
    }

    // Telefones
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
    },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
    $('.telefone').mask(SPMaskBehavior, spOptions);
    $('.cep').mask('00000-000');

    // Passa todos os valores de input para maiusculo removendo acentos
    $('input, select, textarea').on('blur', function () {
        //var strMaiuscula = $(this).val().toUpperCase();
        //$(this).val(strMaiuscula);
        rm_acentos_caps($(this));
    });

    $("#clientes-nav").tab();
    $("#clientes-nome").focus();

    // Escreve isento na Inscrição estadual
    $("#clientes-ie").on('blur', function () {
        var InscEst = $(this);

        if (InscEst.val() == '') {
            InscEst.val('ISENTO');
        }
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
    //$("#clientes-endcep").on('change', function () {
    $(".btn-app").on('click', function () {

        // Zera o Formulario
        limpa_formulário_cep();

        //Nova variável "cep" somente com dígitos.
        var cep = $("#clientes-endcep").val().replace(/\D/g, '').replace('-', '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#clientes-endrua").val("Aguarde")
                $("#clientes-endbairro").val("Aguarde")
                $("#clientes-endcid").val("Aguarde")
                $("#clientes-enduf").val("..")
                //$("#ibge").val("...")

                var dados = '';

                //Consulta o webservice viacep.com.br/
                urlCep = "//viacep.com.br/ws/"+ cep +"/json/?callback=?";
                //urlCep = "http://appservidor.com.br/webservice/cep?CEP=" + cep + "&saida=JSON&CALLBACK=alimenta_combobox";
                $.getJSON(urlCep, function (dados) {

                    if (!("erro" in dados)) {

                        //Atualiza os campos com os valores da consulta.
                        $("#clientes-endrua").val(dados.logradouro);
                        $("#clientes-endbairro").val(dados.bairro);
                        $("#clientes-endcid").val(dados.localidade);
                        $("#clientes-enduf").val(dados.uf);
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

    // Submit
    $("#submitCreate, #submitUpdate").click(function (e) {
        e.preventDefault();
        var urlAtual = window.location.href;
        var Formulario = $("#dynamic-form").serialize();
        var Confirma = Formulario + '&salvar=sim';
        $.post(urlAtual, Confirma);
    });

});