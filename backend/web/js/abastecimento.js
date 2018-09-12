$(document).ready(function () {

    //  Mascaras
    function mascara() {
        $(".dinheiro").maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true,
            affixesStay: false,
            prefix: 'R$ '
        });

        $(".imposto").maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true,
        });

        // Datas
        $('.data').mask('00/00/0000');
    }
    mascara();

    // Passa todos os valores de input para maiusculo removendo acentos
    $('input, select, textarea').on('blur', function () {
        //var strMaiuscula = $(this).val().toUpperCase();
        //$(this).val(strMaiuscula);
        rm_acentos_caps($(this));
    });
});

// Função que remove acentos e caps formulario
function rm_acentos_caps(campo) {
    var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
    //var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c');
    campo.val(valor);
}

function ultimoKM(veiculo) {

    $.ajax({
        url: '/Transportes/backend/web/ajax/ultimo-km/?veiculo=' + veiculo,
        type: 'GET',
        success: function (data) {
            var msg = 'Último KM: ' + data.odometro;
            $('.hint-block').html(msg);
            console.log(data);
        }
    });
}