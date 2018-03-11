/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    // Datas
    $('.data').mask('00/00/0000');

    var urlRelatorio = '/Transportes/backend/web/relatorios/default/get-relatorio/?';

    function getRelatorio() {
        var resultado = '';
        var di = $('#di').val();
        var df = $('#df').val();
        var tipo = $('#tipo').val();
        var status = 'TODOS';
        var p = 'di=' + di + '&df=' + df + '&tipo=' + tipo + '&status=' + status;

        $.ajax({
            url: urlRelatorio + p,
            type: 'GET',
            success: function (data) {
                $.each(data, function (index, value) {
                    var nl = novalinha(value);
                    $("#resultados").append(nl);
                });
            }
        });

        return resultado;
    }

    function novalinha(data) {
        
        var nl = '';
        nl = '<tr>';
        nl += '<td>' + data.nome + '</td>';
        nl += '<td>' + data.descricao + '</td>';
        nl += '<td>' + data.vencimento + '</td>';
        nl += '<td>' + data.valor + '</td>';
        nl += '<td>' + data.status + '</td>';
        nl += '</tr>';
        
        return nl;
    }

    $('#gerar').on('click', function () {
        console.log(getRelatorio());
    });

});