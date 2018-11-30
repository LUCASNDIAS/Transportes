/* 
 * Script jQuery com funções genéricas
 * usado em quase todas as páginas
 */

$(document).ready(function () {

    // Certificado
    function getCertificado() {

        var url = '/Transportes/backend/web/ajax/certificado';

        // Verifica validade
        $.get(url, function (data) {

            if (data.status === true) {
                $('#ajaxcertificado').html(data.msg);
                $('#ajaxvalidade').html(data.validade);
            } else {

            }

        });
    }

    // CT-e
    function getCte() {

        var url = '/Transportes/backend/web/ajax/count-cte';

        // get qtde
        $.get(url, function (data) {
            $("#ajaxcte").html(data);
        });
    }

    // Faturas
    function getFaturas() {

        var url = '/Transportes/backend/web/ajax/count-faturas';

        // get qtde
        $.get(url, function (data) {
            $("#ajaxfaturas").html(data);
        });
    }

    // Clientes
    function getClientes() {

        var url = '/Transportes/backend/web/ajax/count-clientes';

        // get qtde
        $.get(url, function (data) {
            $("#ajaxclientes").html(data);
        });
    }

    function getCor(skin) {

        var cor = '';

        switch (skin) {
            case 'skin-blue':
                cor = '<button class="btn btn-primary">Azul</button>';
                break;
            case 'skin-red':
                cor = '<button class="btn btn-danger">Vermelho</button>';
                break;
            case 'skin-purple':
                cor = '<button class="btn bg-purple">Roxo</button>';
                break;
            case 'skin-yellow':
                cor = '<button class="btn bg-yellow">Laranja</button>';
                break;
            case 'skin-green':
                cor = '<button class="btn btn-success">Verde</button>';
                break;
            default:
                cor = '<button class="btn btn-primary">Azul</button>';
        }

        return cor;
    }

    function attPref() {
        // Tema
        var tema = $('#tema').val();

        // Financeiro
        var f_check = $('#financeiro:checked').val();
        var financeiro = (typeof f_check === 'undefined') ? 0 : f_check;

        // Veiculo
        var v_check = $('#veiculos:checked').val();
        var veiculos = (typeof v_check === 'undefined') ? 0 : v_check;

        // Prefs
        var prefs = $('#pref_id').val();

        var cliente = $('#cliente_id').val();

        var variaveis = '?tema=' + tema + '&financeiro=' + financeiro + '&veiculos=' + veiculos + '&pref_id=' + prefs + '&cliente=' + cliente;
        var url = '/Transportes/backend/web/ajax/save-prefs/' + variaveis;

        // Salva
        $.get(url, function (data) {
            $("#save-prefs").html(data);
        });

    }

    getCertificado();
    getCte();
    getFaturas();
    getClientes();

    var tema = $('body').attr('class').split(' ');
    var atual = tema[1];

    // Mostra o tema atual do usuário
    $('#tema-atual').html(getCor(atual));
    $('#tema').val(atual);

    $('.tema').on('click', function () {
        var tema = $(this).attr('id');
        var botao = getCor(tema);
        $('#tema-novo').html(botao);
        $('#tema').val(tema);
    });

    $('.salvar').on('click', function () {
        attPref();
    });

});