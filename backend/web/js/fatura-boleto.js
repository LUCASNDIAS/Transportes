/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    $("#faturaboleto-dtvencimentotitulo").focus();

    //  Mascaras
    function mascara() {
        $(".dinheiro").maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true,
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

});