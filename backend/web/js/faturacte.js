/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    $("#fatura-sacado").focus();

    //  Mascaras
    function mascara() {
        $(".dinheiro").maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: false,
            affixesStay: false,
            prefix: 'R$ '
        });

        // Datas
        $('.data').mask('00/00/0000');

    }

    // Função que remove acentos e caps formulario
    function rm_acentos_caps(campo) {
        var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
        campo.val(valor);
    }

    mascara();

    $('input, select').on('blur', function () {
        rm_acentos_caps($(this));
    });

    // Checkbox
    function getCheck() {
        var keys = $('.grid-view').yiiGridView('getSelectedRows');
//        var docume = keys.join('/');
        console.log(keys);
        alert(docume);
//        $('#embarques').val('docs');
    }

    $('#embarques').on('click', function () {
        $(this).val('huhu');
    });

    $('#fatura-sacado, #fatura-tipo').on('blur', function () {
        var sacado = $('#fatura-sacado').val();
        if (sacado != '') {
            $('input[name*="tomador"]').val(sacado);
            $('.grid-view').yiiGridView('applyFilter');
            $('input[name^="selection"]').on('click', function () {
                getCheck();
            });
        }
    });

    var sacado = $('#fatura-sacado').val();
    if (sacado == '') {
        $('input[name^="selection"]').hide();
        $('input[name*="tomador"]').val('Selecione o sacado');
        $('input[name*="tomador"]').prop('readonly', true);
    }

    $('input[name^="selection"]').on('click', function () {
        getCheck();
    });
    
    $('#gerar-fake').on('click', function(){
        var embarques = $("#embarques").val();
        
        if (embarques == '') {
            alert('Nenhum embarque selecionado.')
        } else {
            $('#tab_1').trigger('click');
            $('#gerar-fatura').trigger('click');
        }        
    });

});

$(document).on('pjax:complete', function () {
    // Do something after pjax load
    // Checkbox
    function getCheck() {
        var keys = $('.grid-view').yiiGridView('getSelectedRows');
        var docs = keys.join('/');
        $('#embarques').val(docs);
    }

    $('input[name*="tomador"]').prop('readonly', true);
    $('input[name="selection_all"]').hide();
    var sacado = $('#fatura-sacado').val();
    if (sacado == '') {
        $('input[name^="selection"]').hide();
        $('input[name*="tomador"]').val('Selecione o sacado');
        $('input[name*="tomador"]').prop('readonly', true);
        $('.grid-view').yiiGridView('applyFilter');
    }

    $('input[name^="selection"]').on('click', function () {
        getCheck();
    });
});