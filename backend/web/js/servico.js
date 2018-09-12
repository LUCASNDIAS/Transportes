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

    // Função para mover cursor com "enter"
    function mover() {
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
    }

    // Função peso cubado
    function calculoGeral() {

        // Campos Reais
        var realValor = 0;
        var realQtde = 0;

        $(".valorparcela").each(function (i) {

            // Variáveis das notas
            var parcela = $(this).val();

            // Valor total
            realValor += parcela * 1;

            // Total de parcelas
            realQtde = i + 1;

        });

        // Preenchimento do peso cubado e real
        $("#veiculosservico-valor_total").val(realValor.toFixed(2));
        $("#veiculosservico-parcelas").val(realQtde);

    }

    // Passa todos os valores de input para maiusculo removendo acentos
    $('input, select, textarea').on('blur', function () {
        //var strMaiuscula = $(this).val().toUpperCase();
        //$(this).val(strMaiuscula);
        rm_acentos_caps($(this));
        calculoGeral();
    });

    // Controle dos campos dinâmicos de contatos e tabelas
    jQuery(".dynamicform_inner").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_inner .panel-title-contato").each(function (index) {
            jQuery(this).html("Parcela: " + (index + 1));
            var atual = '#veiculosservicopagamento-'+index+'-parcela';
            $(atual).val(index+1);
            // Passa todos os valores de input para maiusculo removendo acentos
            $('input, select, textarea').on('blur', function () {
                calculoGeral();
                rm_acentos_caps($(this));
            });
            calculoGeral();
            mascara();
            mover();
        });
    });
});

// Função que remove acentos e caps formulario
function rm_acentos_caps(campo) {
    var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
    //var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c');
    campo.val(valor);
}

