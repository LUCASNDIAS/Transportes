/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {
    
    var pagina =  $("#pagina").val();

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

        $('.dimensao').maskMoney({
            thousands: '',
            decimal: '.',
            allowZero: true
        });

        $('.peso').maskMoney({
            thousands: '',
            decimal: '.',
            precision: 3,
            allowZero: true
        });

        // Datas
        $('.data').mask('00/00/0000');

        // Hora
        $('.hora').mask('00:00');

        // Placa
        $('.placa').mask('AAA0000');
    }
    mascara();

    // Função peso cubado
    function calculoGeral() {

        var multiplicador = 300;

        var cubado = 0;
        var pesoreal = 0;

        // Campos Reais
        var realNumero = '';
        var realValor = 0;
        var realAltura = '';
        var realLargura = '';
        var realComprimento = '';
        var realPeso = '';
        var realVolumes = 0;
        var realDimensoes = '';

        $(".nfechave").each(function (i) {

            // Variáveis das notas
            var numero = $(this).val();
            var valor = $("input[id='ctedocumentos-" + i + "-vnf']").val().replace(/[R$ ]/g, '');

            // Variável de peso real
            var peso = $("input[id='ctedocumentos-" + i + "-peso']").val();
            // Soma do peso real
            pesoreal += peso * 1;

            // Valor da nota fiscal
            realValor += valor * 1;

            // Mais um each para pegar cada dimensão / volumes
            $(".nfvol").each(function (j) {

                // Variáveis de alt, larg e comp para calcular o peso subado
                var altura = $("input[id='ctedimensoes-" + i + "-" + j + "-altura']").val();
                var largura = $("input[id='ctedimensoes-" + i + "-" + j + "-largura']").val();
                var comprimento = $("input[id='ctedimensoes-" + i + "-" + j + "-comprimento']").val();
                var volumes = ($("input[id='ctedimensoes-" + i + "-" + j + "-volumes']").val() == '') ? 0 : $("input[id='ctedimensoes-" + i + "-" + j + "-volumes']").val();

                if (typeof altura !== "undefined") {

                    // Soma do peso cubado
                    cubado += altura * largura * comprimento * multiplicador * volumes;

                    // Volumes
                    realVolumes += volumes * 1;
                }

            });

        });

//        alert('Real: ' + pesoreal + ' | Cubado: ' + cubado);

        // Preenchimento do peso cubado e real
        $("#cte-pesocubado").val(cubado.toFixed(2));
        $("#cte-pesoreal").val(pesoreal.toFixed(2));

        // Preenchimento dos campos reais
        $("#cte-notasvalor").val(realValor.toFixed(2));
        $("#cte-vcarga").val(realValor.toFixed(2));
        $("#cte-notasvolumes").val(realVolumes);
    }

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

    // Função que remove acentos e caps formulario
    function rm_acentos_caps(campo) {
        var valor = campo.val().replace(/[áàâãÁÀÂÃ]/g, 'a').replace(/[éèêẽÉÈÊẼ]/g, 'e').replace(/[íìîĩÍÌÎĨ]/g, 'i').replace(/[óòôõÓÒÔÕ]/g, 'o').replace(/[úùûũüÚÙÛŨÜ]/g, 'u').replace(/[çÇ]/g, 'c').toUpperCase();
        campo.val(valor);
    }

    // Controle dos campos dinâmicos de contatos e tabelas
    jQuery(".dynamicform_wrapper").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper .panel-title-contato").each(function (index) {
            jQuery(this).html("Nota: " + (index + 1));
            // Passa todos os valores de input para maiusculo removendo acentos
            $('input, select, textarea').on('blur', function () {
                calculoGeral();
                rm_acentos_caps($(this));
            });
            $('.notnfe').hide();
            mascara();
            calculoGeral();
            mover();
        });
    });

    // Controle dos campos dinâmicos de contatos e tabelas
    jQuery(".dynamicform_inner").on("afterInsert afterDelete", function (e, item) {
        // Passa todos os valores de input para maiusculo removendo acentos
        $('input, select, textarea').on('blur', function () {
            calculoGeral();
            rm_acentos_caps($(this));
        });
        $('.notnfe').hide();
        mascara();
        calculoGeral();
        mover();
    });

    jQuery(".dynamicform_wrapper_con").on("afterInsert afterDelete", function (e, item) {
        jQuery(".dynamicform_wrapper_con .panel-title-condutor").each(function (index) {
            jQuery(this).html("Componente: " + (index + 1));
            // Passa todos os valores de input para maiusculo removendo acentos
            $('input, select, textarea').on('blur', function () {
                calculoGeral();
                rm_acentos_caps($(this));
            });
            $('.notnfe').hide();
            mascara();
            calculoGeral();
            mover();
        });
    });

    // Passa todos os valores de input para maiusculo removendo acentos
    $('input, select, textarea').on('blur', function () {
        //var strMaiuscula = $(this).val().toUpperCase();
        //$(this).val(strMaiuscula);
        rm_acentos_caps($(this));
    });

    function calculaFrete() {
        var tabela_id = $("#tabelaAjax").val();
        var pesoreal = $("#cte-pesoreal").val();
        var pesocubado = $("#cte-pesocubado").val();
        var taxaextra = $("#cte-taxaextra").val();
        var desconto = $("#cte-desconto").val();
        var notasvalor = $("#cte-notasvalor").val();
        var notasvolumes = $("#cte-notasvolumes").val();

        $.ajax({
            url: '/Transportes/backend/web/ajax/calculoscte',
            type: 'GET',
            data: {
                tipo: 'ajax',
                tabela: tabela_id,
                pesoreal: pesoreal,
                pesocubado: pesocubado,
                taxaextra: taxaextra,
                desconto: desconto,
                notasvalor: notasvalor,
                notasvolumes: notasvolumes,

            },
            dataType: 'json',
            success: function (data) {

                if (data == 'Tabela não informada' || data == 'Peso não definido' || typeof data.fretetotal === 'undefined') {
                    var erros = '<td colspan="5"><span class="text-red text-bold">' + data + '</span></td>'
                    $(".retornoFinal").html(erros);
                } else {

                    var componentes = {
                        desconto: {nome: 'DESCONTO', valor: data.desconto},
                        tabela_despacho: {nome: 'DESPACHO', valor: data.tabela_despacho},
                        tabela_fretevalor: {nome: 'FRETE VALOR', valor: data.tabela_fretevalor},
                        tabela_gris: {nome: 'GRIS', valor: data.tabela_gris},
                        tabela_itr: {nome: 'ITR', valor: data.tabela_itr},
                        tabela_outros: {nome: 'OUTROS', valor: data.tabela_outros},
                        tabela_pedagio: {nome: 'PEDAGIO', valor: data.tabela_pedagio},
                        tabela_seccat: {nome: 'SECCAT', valor: data.tabela_seccat},
                        taxaextra: {nome: 'TAXA EXTRA', valor: data.taxaextra},
                        valorexcedente: {nome: 'FRETE PESO', valor: data.valorexcedente},
                        valorminimo: {nome: 'FRETE MINIMO', valor: data.valorminimo}
                    };

                    var tamanho = Object.keys(componentes).length;
                    
                    for (tamanho; tamanho>0; tamanho--){
                        $('.remove-item-con').trigger('click');
                    }
                    
                    var c = 0;
                    $.each(componentes, function (key, value) {
                        if (value.valor != '0.00') {
                            $('.add-item-con').trigger('click');
                            $('#ctecomponentes-' + c + '-nome').val(value.nome);
                            $('#ctecomponentes-' + c + '-valor').val(value.valor);
                            c++;
                        }
                    });

//                    for (tamanho; tamanho > 0; tamanho--) {
//                        $('.add-item-con').trigger('click');
//                    }

                    var tabela = '<td>Frete mínimo: <span class="text-bold text-blue">R$' + data.valorminimo + '</span></td>';
                    tabela += '<td>Frete peso: <span class="text-bold text-blue">R$' + data.valorexcedente + '</span></td>';
                    tabela += '<td>Taxa extra: <span class="text-bold text-blue">R$' + data.taxaextra + '</span></td>';
                    tabela += '<td>Desconto: <span class="text-bold text-red">-R$' + data.desconto + '</span></td>';
                    tabela += '<td>Valor total: <span class="text-bold text-blue">R$' + data.fretetotal + '</span></td>';

                    $(".retornoFinal").html(tabela);

                    // Valor total e valor a receber
                    $("#cte-vtprest").val(data.fretetotal);
                    $("#cte-vrec").val(data.fretetotal);
                }
            }
        });
    }

    $("#tabelaAjax").on('change', function () {
        calculaFrete();
    });

    $("#btn-testar").on('click', function () {
        alert($('form').serialize());
    });

    $(".container-items input, .container-items select").on('blur', function () {
        calculoGeral();
    });

    $(".ctetipo").on('change', function () {
        var tipo = $(this).val();

        if (tipo == 'NFE') {
            $(".notnfe").hide('slow');
        } else {
            $('.notnfe').show('slow');
        }
    });

    // Inicia com focus na pesquisa do remetente
    $("#remetente-nome").focus();

    $("#icms, #contingencia, #tpcte, .notnfe, .nf_notasfiscais, .nf_notasoutros, .lotacao").hide();

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
    
    function getOrigem() {
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
    }

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
    
    function getDestino() {
        
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
        
    }

    $("#cte-lota").on('change', function () {
        $('.lotacao').toggle('slow');
    });

    // Envio do CTe (Local)
    var emitente = $("#dono").val();
    $.get("/Transportes/backend/web/ajax/cidades", {envolvidos: emitente})
            .done(function (data) {

                $.each(data, function (key, value) {

                    $("#cte-cmunenv").val(value.codigo);
                    $("#cte-xmunenv").val(value.municipio);
                    $("#cte-ufenv").val(value.uf);

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

            Tagcmun = '#cte-cmunini';
            Tagxmun = '#cte-xmunini';
            Taguf = '#cte-ufini';

        } else {

            Tagcmun = '#cte-cmunfim';
            Tagxmun = '#cte-xmunfim';
            Taguf = '#cte-uffim';

        }

        $(Tagcmun).val(cmun);
        $(Tagxmun).val(xmun);
        $(Taguf).val(uf);

    }

    $('#cte-origem, #cte-destino').on('change', function () {
        var local = $(this).attr('id');
        var valor = $(this).val();

        OrigemDestino(local, valor);

        $('#cte-uffim, #cte-ufini').trigger('change');

    });
    
    function getCfop() {
        
        var uffim = $("#cte-uffim").val();
        var ufini = $("#cte-ufini").val();

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

                        $("#cte-cfop").html(lista);

                    });

        }
    }

    $('#cte-uffim, #cte-ufini').on('change', function () {
        var uffim = $("#cte-uffim").val();
        var ufini = $("#cte-ufini").val();

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

                        $("#cte-cfop").html(lista);

                    });

        }

    });

    $('#cte-cfop').on('change', function () {
        var texto = $('#cte-cfop option:selected').text();
        var separa = texto.split(' - ');

        $("#cte-natop").val(separa[1]);
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
    $("input[id^='icms-']").on('change', function () {
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
        $("input[id^='icms-']").attr('readonly', 'readonly');
//        $("input[id^='icms-']").val('');
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
        
        // Base e Cálculo
        var vbc = $('#cte-vtprest').val();
        var aliq = $('#icms-picms').val();
        var vicms = vbc * aliq / 100;
//        
        $("#icms-vbc").val(vbc);
        $("#icms-vicms").val(vicms.toFixed(2));
        $("#icms-vtottrib").val(vicms.toFixed(2));
        $("#icms-cst").val(vcst);
        $("#icms").show();

    });

    // Tipo de Emissão
    $('#cte-tpemis').on('change', function () {
        if ($(this).val() == '5') {
            $("#contingencia").show('slow');
        } else {
            $("#contingencia").hide('slow');
        }
    });

    // Tipo de Cte
    $('#cte-tpcte').on('change', function () {
        if ($(this).val() != '0') {
            $("#tpcte").show('slow');
        } else {
            $("#tpcte").hide('slow');
        }
    });

    // Tabelas
    // Trigger de change
//    $("#cte-toma, input[id$='-nome']").on('blur', function () {
//        $('#cte-tomador, #cte-remetente, #cte-destinatario, #cte-expedidor, #cte-recebedor, #cte-toma').trigger('change');
//    });

    // Executa tabela Ajax
    $("#cte-tomador, #cte-toma, #cte-remetente, #cte-destinatario, #cte-expedidor, #cte-recebedor").on("change", function () {

        var pagadorCNPJ = $("#cte-tomador").val();

        if (pagadorCNPJ != '') {

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

        }

    });
    
    function getTabela() {
        var pagadorCNPJ = $("#cte-tomador").val();

        if (pagadorCNPJ != '') {

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

        }
    }
    
    // Parte do UPDATE
    if (pagina == 'UPDATE') {
        
        // Calculo do frete
        calculaFrete();        
        
        // Lotação
        if ($('#cte-lota').val() == '1') {
            $('.lotacao').show();
        }
             
        // Nota Fiscal
        if ($('#ctedocumentos-0-tipo').val() != 'NFE') {
            $('.notnfe').show();
        }
        
        // Origem e Destino 
        $('#select-od').hide();
        $('#up-od').on('click', function(){
           $(this).hide();
           getOrigem();
           getDestino();
           $('#select-od').show('slow');
        });
        
        // Cfop
        $('#up-cfop').on('click', function() {
            $('#cte-natop').val('');
            getCfop();
        });
        
        // Tabelas
        $('#up-tabela').on('click', function() {
            getTabela();
        });
        
        // ICMS
        $('#icms').show();
        
        // Calculo de frete.
        $('input').on('blur', function() {
           calculaFrete(); 
        });
        
    }
    
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
            $("#aguarde").hide();
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
                url: "/Transportes/backend/web/cte/default/email/?id=" + formulario.attr('id'),
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