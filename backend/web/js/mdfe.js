/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    function getContratante(chave)
    {
        // Cria o select com os municipios do cliente
        $.get("/Transportes/backend/web/ajax/seleciona-contratante", {chave: chave})
                .done(function (data) {
                    
                    console.log(data);

                    $.each(data, function (key, value) {

                        var valor = value.tomador;

                        $("#mdfe-contratante").val(valor);

                    });

                });
    }

    // Controle dos campos dinâmicos de contatos e tabelas
    jQuery(".dynamicform_wrapper").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper .panel-title-contato").each(function (index) {
            jQuery(this).html("Percurso: " + (index + 1));
            // Passa todos os valores de input para maiusculo removendo acentos
            $('input, select, textarea').on('blur', function () {
                rm_acentos_caps($(this));
            });
        });
    });

    jQuery(".dynamicform_wrapper_car").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper_car .panel-title-carregamento").each(function (index) {
            jQuery(this).html("Município: " + (index + 1));
            var filtro = $("#mdfe-ufcarga").val();
            // Get com as municipios disponíveis
            $.get("/Transportes/backend/web/ajax/municipios?filtro=" + filtro, function (data) {
                var municipios = $.parseJSON(data);
                jQuery('#carregamento-' + index + '-nome').autocomplete({"source": municipios, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                        $('#mdfecarregamento-' + index + '-cmun').val(ui.item.id);
                        $('#mdfecarregamento-' + index + '-xmun').val(ui.item.value);
                        $('#mdfecarregamento-' + index + '-xmun').focus();
                    }});
            });
        });
    });

    jQuery(".dynamicform_wrapper_des").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper_des .panel-title-descarregamento").each(function (index) {
            jQuery(this).html("Município: " + (index + 1));
            var filtro = $("#mdfe-ufdescarga").val();
            // Get com os municipios disponíveis
            $.get("/Transportes/backend/web/ajax/municipios?filtro=" + filtro, function (data) {
                var municipios = $.parseJSON(data);
                jQuery('#descarregamento-' + index + '-nome').autocomplete({"source": municipios, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                        $('#mdfedescarregamento-' + index + '-cmun').val(ui.item.id);
                        $('#mdfedescarregamento-' + index + '-xmun').val(ui.item.value);
                        $('#mdfedescarregamento-' + index + '-xmun').focus();
                    }});
            });
        });
    });

    jQuery(".dynamicform_wrapper_con").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper_con .panel-title-condutor").each(function (index) {
            jQuery(this).html("Motorista: " + (index + 1));
            // Get com as funcionarios disponíveis
            $.get("/Transportes/backend/web/ajax/motoristas", function (data) {
                var condutores = $.parseJSON(data);
                jQuery('#condutor-' + index + '-nome').autocomplete({"source": condutores, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                        $('#mdfecondutor-' + index + '-condutor').val(ui.item.id);
                        $('#mdfecondutor-' + index + '-xnome').val(ui.item.value);
                        $('#mdfecondutor-' + index + '-condutor').focus();
                    }});
            });
        });
    });

    jQuery(".dynamicform_wrapper_doc").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper_doc .panel-title-documentos").each(function (index) {
            jQuery(this).html("Documento: " + (index + 1));
            var novoValor = index + 1;
            $("#mdfe-qtdecte").val(novoValor);
//            var np = $('#mdfedocumentos-' + index + '-chave').val();
//            $.get("/Transportes/backend/web/ajax/seleciona-cte", function (data) {
//                var cte = $.parseJSON(data);
//                jQuery('#mdfedocumentos-' + index + '-chave').autocomplete({"source": cte, "autoFill": true, "minLength": 2, "select": function (event, ui) {
//                        console.log(ui.item);
//                        $('#mdfedocumentos-' + index + '-chave').val(ui.item.value);
//                        $('#mdfedocumentos-' + index + '-chave').focus();
//                    }});
//            });
        });
    });
    
    $('#mdfedocumentos-0-chave').on('blur', function(){
        var chave = $(this).val();
        getContratante(chave);
    });
    
    $("#mdfe-ufcarga").on('change', function () {
        var filtro = $(this).val();
        $.get("/Transportes/backend/web/ajax/municipios?filtro=" + filtro, function (data) {
            var municipios = $.parseJSON(data);
            jQuery('#carregamento-0-nome').autocomplete({"source": municipios, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                    $('#mdfecarregamento-0-cmun').val(ui.item.id);
                    $('#mdfecarregamento-0-xmun').val(ui.item.value);
                    $('#mdfecarregamento-0-xmun').focus();
                }});
        });
    });

    $("#mdfe-ufdescarga").on('change', function () {
        var filtro = $(this).val();
        $.get("/Transportes/backend/web/ajax/municipios?filtro=" + filtro, function (data) {
            var municipios = $.parseJSON(data);
            jQuery('#descarregamento-0-nome').autocomplete({"source": municipios, "autoFill": true, "minLength": 2, "select": function (event, ui) {
                    $('#mdfedescarregamento-0-cmun').val(ui.item.id);
                    $('#mdfedescarregamento-0-xmun').val(ui.item.value);
                    $('#mdfedescarregamento-0-xmun').focus();
                }});
        });
    });

    // Focus no primeiro campo
    $("#mdfe-numero").focus();


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

    // Mascaras para formulários
    $('.dinheiro').maskMoney({
        thousands: '',
        decimal: '.',
        allowZero: true,
        affixesStay: false,
        prefix: 'R$ '
    });
    $('.obrig-din').maskMoney({
        thousands: '',
        decimal: '.',
        allowZero: false,
        affixesStay: false,
        prefix: 'R$ '
    });
    $('.obrig-peso').maskMoney({
        thousands: '',
        decimal: '.',
        precision: 2,
        allowZero: false
    });

//    // Não precisa pois não faço validação no servidor
//    // Submit
//    $("#submitCreate, #submitUpdate").click(function (e) {
//        e.preventDefault();
//        var urlAtual = window.location.href;
//        var Formulario = $("#dynamic-form").serialize();
//        var Confirma = Formulario + '&salvar=sim';
//        $.post(urlAtual, Confirma);
//    });

});