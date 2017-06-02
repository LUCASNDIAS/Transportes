/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    $("#btn-testar").on('click', function () {
        alert($('form').serialize());
    });
    
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
            var valor = $("input[id$='-notasvalorx" + i + "']").val().replace(/[R$ ]/g, '');

            // Variáveis de alt, larg e comp para calcular o peso subado
            var altura = $("input[id$='-notasalturax" + i + "']").val();
            var largura = $("input[id$='-notaslargurax" + i + "']").val();
            var comprimento = $("input[id$='-notascomprimentox" + i + "']").val();
            var volumes = ($("input[id$='-notasvolumesx" + i + "']").val() == '') ? 1 : $("input[id$='-notasvolumesx" + i + "']").val();
            // Soma do peso cubado
            cubado += altura * largura * comprimento * multiplicador * volumes;

            // Variável de peso real
            var peso = $("input[id$='-notaspesox" + i + "']").val();
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
        
        //alert('Real: ' + pesoreal + ' | Cubado: ' + cubado);

        // Preenchimento do peso cubado e real
//        $("#minutas-pesocubado").val(cubado.toFixed(2));
//        $("#minutas-pesoreal").val(pesoreal.toFixed(2));

        // Preenchimento dos campos reais
//        $("#minutas-notasnumero").val(realNumero);
//        $("#minutas-notasvalor").val(realValor);
//        $("#minutas-notasaltura").val(realAltura);
//        $("#minutas-notaslargura").val(realLargura);
//        $("#minutas-notascomprimento").val(realComprimento);
//        $("#minutas-notaspeso").val(realPeso);
//        $("#minutas-notasvolumes").val(realVolumes);
//        $("#minutas-notasdimensoes").val(realDimensoes);
    }
    
    $("div .linhas input, div .linhas select").on('blur', function(){
        calculoGeral();
    });

    // Inicia com focus na pesquisa do remetente
    $("#remetente-nome").focus();

    $("#icms, #contingencia, #tpcte, .nf_notasfiscais, .nf_notasoutros").hide();

    // Campos de Notas com "disabled"
    var camposNFe = ["input[name^='nf_nromax']", "input[name^='nf_nmodx']", "input[name^='nf_nseriex']"];
    var camposNF = [
        "input[name^='nf_nromax']",
        "input[name^='nf_npedx']",
        "select[name^='nf_modx']",
        "input[name^='nf_seriex']",
        "input[name^='nf_demix']",
        "input[name^='nf_ncfopx']",
        "input[name^='nf_pinx']",
    ];
    var camposOutros = [
        "select[name^='nf_tpdocx']",
        "input[name^='nf_descoutrosx']",
        "input[name^='nf_outrosdemix']",
    ];

    function disabled(campos, acao) {
        $.each(campos, function (key, value) {
            if (acao == false) {
                $(value).removeAttr('disabled');
            } else {
                $(value).attr('disabled', 'disabled');
            }
        });
    }

    // Notas Fiscais
    $("#cte-documentos").on('change', function () {
        var documento = $(this).val();
        if (documento == 'NFE') {
            $('.nf_notasfiscais, .nf_notasoutros').hide('slow');
            disabled(camposNF);
            disabled(camposOutros);
        } else if (documento == 'NF') {
            $('.nf_notasfiscais').show('slow');
            $('.nf_notasoutros').hide('slow');
            disabled(camposNF, false);
            disabled(camposOutros);
        } else if (documento == 'OUTROS') {
            $('.nf_notasfiscais').hide('slow');
            $('.nf_notasoutros').show('slow');
            disabled(camposOutros, false);
            disabled(camposNF);
        } else {
            $('.nf_notasfiscais, .nf_notasoutros').hide('slow');
            disabled(camposNF);
            disabled(camposOutros);
        }
    });


    // Validar dados		
    // Adiciona nova linha com dados de fomulário
    $(".adicionarCampo").click(function (e) {

        e.preventDefault();

        var duplicarPrimeiro = 'div.' + $(this).attr('id') + ':first';
        var contarTodos = $('div.' + $(this).attr('id')).length;
        var verificarUltimo = 'div.' + $(this).attr('id') + ':last';

        novoCampo = $(duplicarPrimeiro).clone(true);
        novoCampo.attr("id", contarTodos);
        novoCampo.insertAfter(verificarUltimo);
        novoCampo.find("#0").attr("id", contarTodos);

        $("div .linhas:first input, div .linhas:first select").each(function (index) {
            var idInicial = '#' + $(this).attr('id');
            var novaID = $(this).attr('id').replace('0', contarTodos);
            novoCampo.find(idInicial).attr("id", novaID);
            $('#' + novaID).val('');
        });

//        mascara();
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
    $("input[id$='-dprev']").on('blur', function () {
        calculoGeral();
    });

    // Origem
    $("#cte-remetente, #cte-expedidor").on("blur", function () {

        var remetente = $("#cte-remetente").val();
        var expedidor = $("#cte-expedidor").val();
        var envolvidos = remetente + ',' + expedidor;

        if (remetente != '') {

            // Cria o select com as tabelas do cliente
            $.get("/Transportes/backend/web/ajax/cidades", {envolvidos: envolvidos})
                    .done(function (data) {

                        var lista = '<option value=""> -- Selecione -- </option>';

                        if (data == '' || data == null) {
                            lista += '<option value=""> Endereço não cadastrado. </option>';
                        }

                        $.each(data, function (key, value) {

                            var valor = value.codigo + '|' + value.uf + '|' + value.municipio;

                            lista += '<option value="' + valor + '">' + value.codigo + ' - ' + value.municipio +
                                    ' / ' + value.uf + '</option>';

                        });

                        $("#cte-origem").html(lista);

                    });

        }

    });

    // Destino
    $("#cte-destinatario, #cte-recebedor").on("blur", function () {

        var destinatario = $("#cte-destinatario").val();
        var recebedor = $("#cte-recebedor").val();
        var envolvidos = destinatario + ',' + recebedor;

        if (destinatario != '' || recebedor != '') {

            // Cria o select com os municipios do cliente
            $.get("/Transportes/backend/web/ajax/cidades", {envolvidos: envolvidos})
                    .done(function (data) {

                        var lista = '<option value=""> -- Selecione -- </option>';

                        if (data == '' || data == null) {
                            lista += '<option value=""> Endereço não cadastrado. </option>';
                        }

                        $.each(data, function (key, value) {

                            var valor = value.codigo + '|' + value.uf + '|' + value.municipio;

                            lista += '<option value="' + valor + '">' + value.codigo + ' - ' + value.municipio +
                                    ' / ' + value.uf + '</option>';

                        });

                        $("#cte-destino").html(lista);

                    });

        }

    });

    // Envio do CTe (Local)
    var emitente = $("#cte-emitente").val();
    $.get("/Transportes/backend/web/ajax/cidades", {envolvidos: emitente})
            .done(function (data) {

                $.each(data, function (key, value) {

                    $("#cte-ide_cmunenv").val(value.codigo);
                    $("#cte-ide_xmunenv").val(value.municipio);
                    $("#cte-ide_ufenv").val(value.uf);

                });

            });

    // Função Campos de Origem / Destino
    function OrigemDestino(local, valor) {

        var separa = valor.split('|');

        // Valores
        var cmun = separa[0];
        var xmun = separa[2];
        var uf = separa[1];

        // Tags
        var Tagcmun = '';
        var Tagxmun = '';
        var Taguf = '';

        if (local == 'cte-origem') {

            Tagcmun = '#cte-ide_cmunini';
            Tagxmun = '#cte-ide_xmunini';
            Taguf = '#cte-ide_ufini';

        } else {

            Tagcmun = '#cte-ide_cmunfim';
            Tagxmun = '#cte-ide_xmunfim';
            Taguf = '#cte-ide_uffim';

        }

        $(Tagcmun).val(cmun);
        $(Tagxmun).val(xmun);
        $(Taguf).val(uf);

    }

    $('#cte-origem, #cte-destino').on('change', function () {
        var local = $(this).attr('id');
        var valor = $(this).val();

        OrigemDestino(local, valor);

        $('#cte-ide_uffim, #cte-ide_ufini').trigger('change');

    });

    $('#cte-ide_uffim, #cte-ide_ufini').on('change', function () {
        var uffim = $("#cte-ide_uffim").val();
        var ufini = $("#cte-ide_ufini").val();

        if (uffim != '' && ufini != '') {
            if (uffim == ufini) {
                var interestadual = 0;
            } else {
                var interestadual = 1;
            }

            $.get("/Transportes/backend/web/ajax/cfop", {interestadual: interestadual})
                    .done(function (data) {

                        var lista = '<option value=""> -- Selecione -- </option>';

                        if (data == '' || data == null) {
                            lista += '<option value=""> CFOP não encontrado. </option>';
                        }

                        $.each(data, function (key, value) {

                            var valor = value.cfop + ' - ' + value.nat;

                            lista += '<option value="' + value.cfop + '">' + valor + '</option>';

                        });

                        $("#cte-ide_cfop").html(lista);

                    });

        }

    });

    $('#cte-ide_cfop').on('change', function () {
        var texto = $('#cte-ide_cfop option:selected').text();
        var separa = texto.split(' - ');

        $("#cte-ide_natop").val(separa[1]);
    });

    // Tomador
    $('#cte-toma').on('change', function () {
        var toma = $(this).val();
        var tomador = '';
        switch (toma) {
            case '0':
                tomador = $("#cte-remetente").val();
                break;
            case '1':
                tomador = $('#cte-expedidor').val();
                break;
            case '2':
                tomador = $('#cte-recebedor').val();
                break;
            case '3':
                tomador = $('#cte-destinatario').val();
                break;
        }

        // Para os valores diferentes de "outros (4)"
        if (toma != '4') {
            $("#cte-tomador").val(tomador);
        } else {
            $("#cte-tomador").val('');
            $('#tomador-nome').focus();
        }

    });

    // ICMS Juntar os valores do ICMS no Campo #cte-icms separados por \|\
    function icms() {
        var cst = $("#icms-cst").val();
        var predbc = $('#icms-predbc').val();
        var vbc = $('#icms-vbc').val();
        var picms = $('#icms-picms').val();
        var vicms = $('#icms-vicms').val();
        var vbcstret = $('#icms-vbcstret').val();
        var vicmsstret = $('#icms-vicmsstret').val();
        var picmsstret = $('#icms-picmsstret').val();
        var vcred = $('#icms-vcred').val();
        var vtottrib = $('#icms-vtottrib').val();
        var outraUF = false;

        var icms = cst + '|' + predbc + '|' + vbc + '|' + picms + '|' + vicms
                + '|' + vbcstret + '|' + vicmsstret + '|' + picmsstret + '|' + vcred
                + '|' + vtottrib + '|' + outraUF;

        $('#cte-icms').val(icms);
    }
    $("input[name^='icms-']").on('change', function () {
        icms();
    });

    function carga() {
        var vcarga = $('#carga-vcarga').val();
        var prodpred = $('#carga-prodpred').val();
        var xoutcat = $('#carga-xoutcat').val();

        var carga = vcarga + '|' + prodpred + '|' + xoutcat;

        $("#cte-infcarga").val(carga);
    }
    $("input[name^='carga-']").on('change', function () {
        carga();
    });

    // ReadOnly de acordo com o ICMS
    var icms00 = ['#icms-vbc', '#icms-picms', '#icms-vicms'];
    var icms20 = ['#icms-vbc', '#icms-picms', '#icms-vicms', '#icms-predbc'];
    var icms40 = [];
    var icms41 = [];
    var icms51 = [];
    var icms60 = ['#icms-vbcstret', '#icms-vicmsstret', '#icms-picmsstret', '#icms-vcred'];
    var icms90 = ['#icms-predbc', '#icms-vbc', '#icms-picms', '#icms-vcred'];
    var icms90SN = ['#icms-vtottrib'];

    function readonly(campos) {
        $.each(campos, function (key, value) {
            $(value).removeAttr('readonly');
        });
    }

    $("#tributo-icms").on('change', function () {
        $("input[name^='icms-']").attr('readonly', 'readonly');
        $("input[name^='icms-']").val('');
        $("#cte-icms").val('');
        var tributo = $(this).val();
        var tipo = '';
        var vcst = '';
        switch (tributo) {
            case '00':
                tipo = icms00;
                vcst = '00';
                break;
            case '20':
                tipo = icms20;
                vcst = '20';
                break;
            case '40':
                tipo = icms40;
                vcst = '40';
            case '41':
                tipo = icms41;
                vcst = '41';
                break;
            case '51':
                tipo = icms51;
                vcst = '51';
                break;
            case '60':
                tipo = icms60;
                vcst = '60';
                break;
            case '90':
                tipo = icms90;
                vcst = '90';
                break;
            case '90SN':
                tipo = icms90SN;
                vcst = '90';
                break;
        }

        readonly(tipo);

        $("#icms-cst").val(vcst);
        $("#icms").show();

    });

    // Tipo de Emissão
    $('#cte-ide_tpemis').on('change', function () {
        if ($(this).val() == '5') {
            $("#contingencia").show('slow');
        } else {
            $("#contingencia").hide('slow');
        }
    });

    // Tipo de Cte
    $('#cte-ide_tpcte').on('change', function () {
        if ($(this).val() != '0') {
            $("#tpcte").show('slow');
        } else {
            $("#tpcte").hide('slow');
        }
    });

//    // Tabelas
//    // Trigger de change
//    $("#cte-toma, input[id$='-nome']").on('blur', function () {
//        $('#cte-tomador, #cte-remetente, #cte-destinatario, #cte-expedidor, #cte-recebedor, #cte-toma').trigger('change');
//    });
//
//    // Executa tabela Ajax
//    $("#cte-tomador, #cte-toma, #cte-remetente, #cte-destinatario, #cte-expedidor, #cte-recebedor").on("change", function () {
//
//        var pagadorCNPJ = $("#cte-tomador").val();
//
//        if (pagadorCNPJ != '') {
//
//            // Cria o select com as tabelas do cliente
//            $.get("/Transportes/backend/web/ajax/tabcli", {cnpj: pagadorCNPJ})
//                    .done(function (data) {
//
//                        var lista = '<option value=""> -- Selecione -- </option>';
//
//                        if (data == '') {
//                            lista += '<option value=""> Cliente sem tabelas cadastradas </option>';
//                        }
//
//                        $.each(data, function (key, value) {
//
//                            lista += '<option value="' + value.id + '">' + value.nome + '</option>';
//
//                        });
//
//                        $("#tabelaAjax").html(lista);
//
//                    });
//
//        }
//
//
//    });

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