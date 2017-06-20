/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

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

    // Submit
    $("#submitCreate, #submitUpdate").click(function (e) {
        e.preventDefault();
        var urlAtual = window.location.href;
        var Formulario = $("#dynamic-form").serialize();
        var Confirma = Formulario + '&salvar=sim';
        $.post(urlAtual, Confirma);
    });

});