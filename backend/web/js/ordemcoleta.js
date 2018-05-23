/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    // Inicia com focus na pesquisa do remetente
    $("#remetente-nome").focus();
    
    // Remover consignatario
    $('.rm-cons').on('click', function() {
        $('#ordemcoleta-consignatario, #consignatario-nome').val('');
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
    mascara();

    // Função peso cubado
    function calculoGeral() {

        var multiplicador = 300;

        var cubado = 0;
        var pesoreal = 0;

        // Campos Reais
        var realNumero = '';
        var realValor = '';
        var realAltura = '';
        var realLargura = '';
        var realComprimento = '';
        var realPeso = '';
        var realVolumes = '';
        var realDimensoes = '';

        $("input[name^='notasnumerox']").each(function (i) {

            // Variáveis das notas
            var numero = $(this).val();
            var valor = $("#ordemcoleta-notasvalorx" + i).val().replace(/[R$ ]/g, '');

            // Variáveis de alt, larg e comp para calcular o peso subado
            var altura = $("#ordemcoleta-notasalturax" + i).val();
            var largura = $("#ordemcoleta-notaslargurax" + i).val();
            var comprimento = $("#ordemcoleta-notascomprimentox" + i).val();
            var volumes = ($("#ordemcoleta-notasvolumesx" + i).val() == '') ? 1 : $("#ordemcoleta-notasvolumesx" + i).val();
            // Soma do peso cubado
            cubado += altura * largura * comprimento * multiplicador * volumes;

            // Variável de peso real
            var peso = $("#ordemcoleta-notaspesox" + i).val();
            // Soma do peso real
            pesoreal += peso * 1;

            // Campos Reais
            realNumero += '|' + numero;
            realValor += '|' + valor;
            realAltura += '|' + altura;
            realLargura += '|' + largura;
            realComprimento += '|' + comprimento;
            realPeso += '|' + peso;
            realVolumes += '|' + volumes;
            realDimensoes += '|' + altura + 'x' + largura + 'x' + comprimento;

        });

        // Preenchimento do peso cubado e real
        $("#ordemcoleta-pesocubado").val(cubado.toFixed(2));
        $("#ordemcoleta-pesoreal").val(pesoreal.toFixed(2));

        // Preenchimento dos campos reais
        $("#ordemcoleta-notasnumero").val(realNumero);
        $("#ordemcoleta-notasvalor").val(realValor);
        $("#ordemcoleta-notasaltura").val(realAltura);
        $("#ordemcoleta-notaslargura").val(realLargura);
        $("#ordemcoleta-notascomprimento").val(realComprimento);
        $("#ordemcoleta-notaspeso").val(realPeso);
        $("#ordemcoleta-notasvolumes").val(realVolumes);
        $("#ordemcoleta-notasdimensoes").val(realDimensoes);
    }

    // Passa todos os valores de input para maiusculo removendo acentos
    $('input, select, textarea').on('blur', function () {
        //var strMaiuscula = $(this).val().toUpperCase();
        //$(this).val(strMaiuscula);
        rm_acentos_caps($(this));
    });


    // Validar dados		
    // Adiciona nova linha com dados de fomulário
    $(".adicionarCampo").click(function (e) {

        e.preventDefault();

        var duplicarPrimeiro = 'div.' + $(this).attr('id') + ':first';
        var contarTodos = $('div.' + $(this).attr('id')).length;
        var verificarUltimo = 'div.' + $(this).attr('id') + ':last';

        var novaIDnota = 'ordemcoleta-notasnumerox' + contarTodos;
        var novaIDvalor = 'ordemcoleta-notasvalorx' + contarTodos;
        var novaIDaltura = 'ordemcoleta-notasalturax' + contarTodos;
        var novaIDlargura = 'ordemcoleta-notaslargurax' + contarTodos;
        var novaIDcomprimento = 'ordemcoleta-notascomprimentox' + contarTodos;
        var novaIDpeso = 'ordemcoleta-notaspesox' + contarTodos;
        var novaIDvolumes = 'ordemcoleta-notasvolumesx' + contarTodos;

        novoCampo = $(duplicarPrimeiro).clone(true);
        novoCampo.attr("id", contarTodos);
        novoCampo.find("input").removeClass("has-success");
        novoCampo.find("#ordemcoleta-notasnumerox0").attr("id", novaIDnota);
        novoCampo.find("#ordemcoleta-notasvalorx0").attr("id", novaIDvalor);
        novoCampo.find("#ordemcoleta-notasalturax0").attr("id", novaIDaltura);
        novoCampo.find("#ordemcoleta-notaslargurax0").attr("id", novaIDlargura);
        novoCampo.find("#ordemcoleta-notascomprimentox0").attr("id", novaIDcomprimento);
        novoCampo.find("#ordemcoleta-notaspesox0").attr("id", novaIDpeso);
        novoCampo.find("#ordemcoleta-notasvolumesx0").attr("id", novaIDvolumes);
        novoCampo.find("#0").attr("id", contarTodos);
        novoCampo.insertAfter(verificarUltimo);

        // Remove os valores dos novos campos
        var novoIDnota = '#' + novaIDnota;
        var novoIDvalor = '#' + novaIDvalor;
        var novoIDaltura = '#' + novaIDaltura;
        var novoIDlargura = '#' + novaIDlargura;
        var novoIDcomprimento = '#' + novaIDcomprimento;
        var novoIDpeso = '#' + novaIDpeso;
        var novoIDvolumes = '#' + novaIDvolumes;

        $(novoIDnota).val('');
        $(novoIDvalor).val('');
        $(novoIDaltura).val('');
        $(novoIDlargura).val('');
        $(novoIDcomprimento).val('');
        $(novoIDpeso).val('');
        $(novoIDvolumes).val('');

        mascara();
        calculoGeral();
    });

    $(".remover, .adicionarCampo").on("mouseenter", function () {
        $(this).css('cursor', "pointer");
    });

    //Remove uma linha do formulário
    $('.remover').click(function () {
        var removerDiv = '#' + $(this).attr('id');
        if ($(this).attr('id') != 0) {
            $(removerDiv).remove();
        }
        calculoGeral();
    });

    // Calcula peso cubado
    $("input[id^='ordemcoleta-notas']").on('blur', function () {
        calculoGeral();
    });

    // Pagador - CNPJ
    $("#ordemcoleta-pagadorenvolvido, #ordemcoleta-remetente, #ordemcoleta-destinatario, #ordemcoleta-consignatario").on("change", function () {
        var campoCNPJ = '#ordemcoleta-' + $("#ordemcoleta-pagadorenvolvido").val().toLowerCase();

        var pagadorCNPJ = '';

        if ($("#ordemcoleta-pagadorenvolvido").val() != '') {
            pagadorCNPJ = $(campoCNPJ).val();

            // Cria o select com as tabelas do cliente
            $.get("/Transportes/backend/web/ajax/tabcli", {cnpj: pagadorCNPJ})
                    .done(function (data) {

                        var lista = '<option value=""> -- Selecione -- </option>';

                        if (data == '') {
                            lista += '<option value=""> Cliente sem tabelas cadastradas </option>';
                        }

                        $.each(data, function (key, value) {

                            lista += '<option value="' + value.id + '">' + value.nome + '</option>';

                        });

                        $("#tabelaAjax").html(lista);

                    });

        } else {
            pagadorCNPJ = '';
        }

        $("#ordemcoleta-pagadorcnpj").val(pagadorCNPJ);


    });

    // Tabelas no campo Real
    $("input[id^='tabelaAuto']").bind('blur', function () {

        var tabelas = '';
        var controle = 0;

        for (i = 0; i <= 4; i++) {

            var idAtual = '#tabelaAuto' + i;
            var campoAtual = $(idAtual).val();

            // Verifica se há algo preenchido
            if (campoAtual != '') {

                // Pesquisa pelo separador
                var n = campoAtual.search(" | ");

                // separador ' | ' localizado
                if (n != -1) {
                    // Separa ID do Nome
                    var separa = campoAtual.split(' | ');
                    tabelas = tabelas + '|' + separa[0];
                    controle++;

                } else {
                    alert('Favor selecionar uma tabela válida.');
                }

                $("#tabelas").val(tabelas);

            } else {

            }
        }

        if (controle == 0) {
            $("#tabelas").val('');
        }

    });

    function calculaFrete() {
        var formulario = $("#ordemcoleta-form").serialize();
//        alert(formulario);

        $.ajax({
            url: '/Transportes/backend/web/ajax/calculosoc',
            type: 'POST',
            data: {
                tipo: 'ajax',
                test: formulario
            },
            dataType: 'json',
            success: function (data) {
                if (data == 'Tabela não informada' || data == 'Peso não definido' || typeof data.fretetotal === 'undefined') {
                    var erros = '<td colspan="5"><span class="text-red text-bold">' + data + '</span></td>'
                    $(".retornoFinal").html(erros);
                } else {

                    var tabela = '<td>Frete mínimo: <span class="text-bold text-blue">R$' + data.valorminimo + '</span></td>';
                    tabela += '<td>Frete peso: <span class="text-bold text-blue">R$' + data.valorexcedente + '</span></td>';
                    tabela += '<td>Taxa extra: <span class="text-bold text-blue">R$' + data.taxaextra + '</span></td>';
                    tabela += '<td>Desconto: <span class="text-bold text-red">-R$' + data.desconto + '</span></td>';
                    tabela += '<td>Valor total: <span class="text-bold text-blue">R$' + data.fretetotal + '</span></td>';

                    $(".retornoFinal").html(tabela);
                }
            }
        });
    }

    // Retorna o Calculo quando os seletores são alterados.
    $("input, select").on('change', function () {
        calculaFrete();
    });

    // Calcula o Frete automaticamente ao acessar a página
    calculaFrete();

    // 
    $("#aguarde").hide();

    // Envia Email
    $("#enviar-email").on('click', function () {

        $("#aguarde").show();
        var formulario = $('form[name="form-envio"]');
        var remetente = $('#remetente').val();
        var destinatario = $('#destinatario').val();
        var consignatario = $('#consignatario').val();
        var outros = $('#outros').val();

        if (remetente == '' && destinatario == '' && consignatario == '' && outros == '') {
            alert('Informe pelo menos um endereço de email para o envio');
        } else {

            var emails = '';

            if (remetente != '') {
                emails += remetente;
            }

            if (destinatario != '') {

                if (emails == '') {
                    emails += destinatario;
                } else {
                    emails += ',' + destinatario;
                }
            }

            if (consignatario != '') {

                if (emails == '') {
                    emails += consignatario;
                } else {
                    emails += ',' + consignatario;
                }
            }

            if (outros != '') {

                if (emails == '') {
                    emails += outros;
                } else {
                    emails += ',' + outros;
                }
            }

            $.ajax({
                url: "/Transportes/backend/web/ordemcoleta/default/send?id=" + formulario.attr('id'),
                data: {
                    'emails': emails
                },
                dataType: "json",
                type: "GET"
            }).done(function (data) {
                $("#aguarde").hide();
                // status msg class icone
                $("#retornoEnvio").addClass(data.class);
                $("#retornoEnvio i").addClass(data.icone);
                $("#retornoEnvio h4").append(data.msg);
            }).fail(function (jqXHR, textStatus) {
                $("#aguarde").hide();
                $("#retornoEnvio").addClass('alert alert-danger');
                $("#retornoEnvio i").addClass('icon fa fa-warning');
                $("#retornoEnvio h4").append('Houve um erro. Tente novamente mais tarde');
            });
            ;


        }
    });

    // Submit
    /*
     $("#submitCreate, #submitUpdate").click(function(e){
     e.preventDefault();
     var urlAtual = window.location.href;
     var Formulario = $("#clientes-form").serialize();
     var Confirma = Formulario + '&salvar=sim';
     $.post( urlAtual, Confirma );
     });
     */

});