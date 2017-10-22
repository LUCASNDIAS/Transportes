/**
 * Script em jQuery com funções para formulários
 * 
 * A principal e mais usada é a que troca de campos
 * usando o "Enter" ou "TAB"
 */

$(document).ready(function () {

    // Verifica todos os campos tipo "text"
    // e possibilita avancar campos usando o 'Enter'
    $('input:text, select').keypress(function (e) {
        if (e.which == 13) {
            textboxes = $("input,select");
            currentBoxNumber = textboxes.index(this);
            if (textboxes[currentBoxNumber + 1] != null) {
                nextBox = textboxes[currentBoxNumber + 1]
                nextBox.focus();
                e.preventDefault();
            }
        } else {
            return true;
        }
    });
    
    // Função que remove acentos e caps formulario
    function rm_acentos_caps(campo) {
        var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
        campo.val(valor);
    }

    //  Mascaras
    function mascara() {
        $(".dinheiro").maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true,
            affixesStay: false,
            prefix: 'R$ '
        });

        $('.dimensao').maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true
        });

        $('.peso').maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true
        });

        // Datas
        $('.data').mask('00/00/0000');

        // Hora
        $('.hora').mask('00:00');

        // Placa
        $('.placa').mask('AAA-0000');
    }
    //mascara();
    
    // Função que remove acentos e caps formulario
    function rm_acentos_caps(campo) {
        //var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
        var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c');
        campo.val(valor);
    }
    
    // Passa todos os valores de input para maiusculo removendo acentos
    $('input, select, textarea').on('blur', function () {
        //var strMaiuscula = $(this).val().toUpperCase();
        //$(this).val(strMaiuscula);
        rm_acentos_caps($(this));
    });

});