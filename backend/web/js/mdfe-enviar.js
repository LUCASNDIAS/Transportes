/* 
 * Script jQuery com funções genéricas
 * usado em quase todas as páginas
 */

$(document).ready(function () {

    // Inicia as ações pelo click
    $("#btn-enviar").on('click', function () {

        desativaBarra('gerar');
        desativaBarra('assinar');
        desativaBarra('validar');
        desativaBarra('enviar');
        desativaBarra('recibo');
        desativaBarra('protocolo');
        desativaBarra('pdf');

        var id = $(this).attr('n');
        gerarXml(id);
    });

    // Função que atualiza a geraçao do XML
    function gerarXml(id) {

        var etapa = 'gerar';
        var url = '/Transportes/backend/web/mdfe/default/' + etapa + '-xml/?id=' + id;

        // Ativa a animação da barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Gerando XML do MDF-e';

        // Muda o texto de resultados
        mudaTexto(etapa, texto);

        // Solicita criação do xml
        $.get(url, function (data) {

            if (data.status === true) {
                // Sucesso
                sucessoBarra(etapa);

                var sucesso = 'Arquivo gerado com sucesso.';
                mudaTexto(etapa, sucesso);

                // Assina XML
                assinarXml(id);

            } else {
                // Mostra que houve erro na Barra
                erroBarra(etapa);
                $.each(data.erros, function (key, value) {
                    erroTexto(etapa, value);
                });
            }

        });
    }

    function assinarXml(id) {
        var etapa = 'assinar';
        var url = '/Transportes/backend/web/mdfe/default/' + etapa + '-xml/?id=' + id;

        // Ativa a animação da barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Assinando XML do MDF-e.';

        // Muda o texto de resultados
        mudaTexto(etapa, texto);

        // Solicita assinatura do xml
        $.get(url, function (data) {

            if (data.status === true) {
                // Sucesso
                sucessoBarra(etapa);

                var sucesso = 'Arquivo assinado com sucesso.';
                mudaTexto(etapa, sucesso);

                // validar XML
                validarXml(id);

            } else {
                // Mostra que houve erro na Barra
                erroBarra(etapa);

                // Mostra os erros para o cliente
                $.each(data.erros, function (key, value) {
                    erroTexto(etapa, value);
                });
            }

        });
    }

    function validarXml(id) {
        var etapa = 'validar';
        var url = '/Transportes/backend/web/mdfe/default/' + etapa + '-xml/?id=' + id;

        // Ativa a animação da barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Validando schema do arquivo.';

        // Muda o texto de resultados
        mudaTexto(etapa, texto);

        // Solicita assinatura do xml
        $.get(url, function (data) {

            if (data.status === true) {
                // Sucesso
                sucessoBarra(etapa);

                var sucesso = 'Arquivo válido.';
                mudaTexto(etapa, sucesso);

                // Enviar XML
                enviarXml(id);

            } else {
                // Mostra que houve erro na Barra
                erroBarra(etapa);

                // Mostra os erros para o cliente
                $.each(data.erros, function (key, value) {
                    erroTexto(etapa, value);
                });
            }

        });
    }

    function enviarXml(id) {
        var etapa = 'enviar';
        var url = '/Transportes/backend/web/mdfe/default/' + etapa + '-xml/?id=' + id;

        // Ativa a animação da barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Enviando arquivo para a SEFAZ.';

        // Muda o texto de resultados
        mudaTexto(etapa, texto);

        // Solicita assinatura do xml
        $.get(url, function (data) {

            if (data.nRec !== '') {
                //Sucesso
                sucessoBarra(etapa);

                mudaTexto(etapa, data.xMotivo + '.<br />Recibo: ' + data.nRec);

                // Consultar Recibo XML
                reciboXml(id, data.nRec, false);

            } else {
                // Mostra que houve erro na Barra
                erroBarra(etapa);

                mudaTexto(etapa, data.xMotivo);
            }
        });
    }

    function reciboXml(id, recibo, repetir = false) {
        var etapa = 'recibo';
        var url = '/Transportes/backend/web/mdfe/default/' + etapa + '-xml/?id=' + id + '&recibo=' + recibo;

        if (repetir == false) {
            // Ativa a animação da barra
            ativaBarra(etapa);

            // Texto informativo
            var texto = 'Consultando recibo referente ao lote.';

            // Muda o texto de resultados
            mudaTexto(etapa, texto);

        }

        // Solicita recibo do xml
        $.get(url, function (data) {

            console.log(data);

            if (data.cStat == '105') {
                // Lote ainda sendo processado
                var txttenta = data.xMotivo + '. <br />Tentando novamente';
                mudaTexto(etapa, txttenta);

                // Tenta novamente
                setTimeout(function () {
                    reciboXml(id, recibo, true);
                }, 1000);
            } else if (data.cStat == '106') {
                // Lote não Localizado
                var txtreenvia = data.xMotivo + '. <br />Reenviando MDF-e.';
                mudaTexto(etapa, txtreenvia);

                // Desativa a barra
                desativaBarra(etapa);

                // Envia novamente
                enviarXml(id);

            } else {
                // Verificamos se foi autorizado
                if (data.aProt.cStat == '100') {
                    //Sucesso
                    sucessoBarra(etapa);

                    var txtsucesso = data.aProt.xMotivo + '<br />Chave: ' +
                            data.aProt.chMDFe + '<br />Protocolo: ' + data.aProt.nProt;

                    // Mostra o texto com os dados da autorização
                    mudaTexto(etapa, txtsucesso);

                    // Adiciona o protocolo
                    protocoloXml(id, recibo);
                } else if (data.aProt.cStat == '580') {
                    // Erro (não autorizado)
                    erroBarra(etapa);

                    var txterro = data.aProt.cStat + ' - ' + data.aProt.xMotivo;

                    GetXml(id);

                    // Mostra o motivo da não autorização
                    mudaTexto(etapa, txterro);

                    setTimeout(function () {
                        var xml = $("textarea").val();
                        ShemaXML(xml);
                    }, 500);

                } else if (data.aProt.cStat == '204' || data.aProt.cStat == '218') {
                    // Erro => MDFe já autorizado
                    erroBarra(etapa);

                    var txterro = data.aProt.cStat + ' - ' + data.aProt.xMotivo;

                    $('#motivo-erro').html('Tentando gerar PDF do MDF-e.');
                    $('#resultado-protocolo').html('Protocolo já adicionado.');

                    novoProtocolo(id);
                    
                    // Gerar PDF
                    //gerarPdf(id);

                } else {
                    // Erro (não autorizado)
                    erroBarra(etapa);

                    var txterro = data.aProt.cStat + ' - ' + data.aProt.xMotivo;

                    // Mostra o motivo da não autorização
                    mudaTexto(etapa, txterro);
                }
            }
        });
    }
    
    function novoProtocolo(id) {
        var etapa = 'protocolo';
        var url = '/Transportes/backend/web/mdfe/default/consulta-chave/?id=' + id;
        
        // Ativa a animação da barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Adicionando protocolo.';
        
        // Muda o texto de resultados
        mudaTexto(etapa, texto);
        
        // Solicita protocolo do xml
        $.get(url, function (data) {

            if (data.status === true) {
                // Sucesso
                sucessoBarra(etapa);

                var sucesso = 'Retorno protocolado<br />Arquivo: ' + data.filename;
                mudaTexto(etapa, sucesso);

                // Gerar PDF
                gerarPdf(id);

            } else {
                
                console.log(data);
                // Mostra que houve erro na Barra
                erroBarra(etapa);

                // Mostra os erros para o cliente
                $.each(data.erros, function (key, value) {
                    erroTexto(etapa, value);
                });
            }
        });
    }

    function GetXml(id) {

        var url = '/Transportes/backend/web/mdfe/default/' + 'get' + '-xml/?id=' + id;

        // Solicita protocolo do xml
        $.get(url, function (data) {

            //console.log(data.documentElement.textContent);
            $("textarea").val(data.documentElement.textContent);

        });
    }

    function protocoloXml(id, recibo) {
        var etapa = 'protocolo';
        var url = '/Transportes/backend/web/mdfe/default/' + etapa + '-xml/?id=' + id + '&recibo=' + recibo;

        // Ativa a animação da barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Adicionando protocolo.';

        // Muda o texto de resultados
        mudaTexto(etapa, texto);

        // Solicita protocolo do xml
        $.get(url, function (data) {

            if (data.status === true) {
                // Sucesso
                sucessoBarra(etapa);

                var sucesso = 'Autorização protocolada.<br />Arquivo: ' + data.filename;
                mudaTexto(etapa, sucesso);

                // Gerar PDF
                gerarPdf(id);

            } else {
                
                console.log(data);
                // Mostra que houve erro na Barra
                erroBarra(etapa);

                // Mostra os erros para o cliente
                $.each(data.erros, function (key, value) {
                    erroTexto(etapa, value);
                });
            }
        });
    }

    function gerarPdf(id) {
        var etapa = 'pdf';
        var url = '/Transportes/backend/web/mdfe/default/gerar-' + etapa + '/?id=' + id;

        // Ativa a barra
        ativaBarra(etapa);

        // Texto informativo
        var texto = 'Gerando arquivo PDF.';

        // Muda o texto de resultados
        mudaTexto(etapa, texto);

        // Solicita criação do pdf
        $.get(url, function (data) {

            if (data.status === true) {
                // Sucesso
                sucessoBarra(etapa);

                var sucesso = 'Arquivo gerado com suceso.<br />Arquivo: ' + data.filename;
                mudaTexto(etapa, sucesso);
                
                $('#motivo-erro').html('MDF-e já enviado. <br>Arquivo PDF gerado com sucesso');
                $('#motivo-erro').removeClass('text-red').addClass('text-green');
                                
                abrePDF(data.filename);

            } else {
                // Mostra que houve erro na Barra
                erroBarra(etapa);
                // Mostra os erros para o cliente
                $.each(data.erros, function (key, value) {
                    erroTexto(etapa, value);
                });
                
                $('#motivo-erro').html('Erro ao gerar PDF.');
            }
        });
    }

    function ShemaXML(xml) {
        // Ativa a animação da barra
        ativaBarra('recibo');

        $('#motivo-erro').html('Verificando falha no Shema XML.');

        var txtSub = "Validar";
        var proxy = "https://cors-anywhere.herokuapp.com/";
        var myUrl = "https://www.sefaz.rs.gov.br/ASP/AAE_ROOT/CTE/SAT-WEB-CTE-VAL_1.asp";

        var request = $.ajax({
            url: proxy + myUrl,
            type: "POST",
            data: {txtCte: xml, submit1: txtSub},
            dataType: 'html'
        }).done(function (html) {
            $("#oculto").append(html);
            resultadoShema();
        });

    }

    function resultadoShema() {
        // Barra de Erro
        erroBarra('recibo');

        var resultado = $("#oculto").find('.tdVal:last').html();
        $("#motivo-erro").html(resultado);
    }
    
    function abrePDF(url) {
        var local = url.replace('/var/www/html', '');
        window.open(local,'LND Sistemas - MDF-e');
    }

    function desativaBarra(etapa) {
        var barra = '#barra-' + etapa;
        $(barra).removeClass('active progress-bar-warning progress-bar-danger progress-bar-success').addClass('progress-bar-primary');
    }

    function ativaBarra(etapa) {
        var barra = '#barra-' + etapa;
        $(barra).removeClass('progress-bar-primary progress-bar-success progress-bar-danger').addClass('active progress-bar-warning');
    }

    function erroBarra(etapa) {
        var barra = '#barra-' + etapa;
        $(barra).removeClass('progress-bar-primary active progress-bar-warning progress-bar-success').addClass('progress-bar-danger');
    }

    function sucessoBarra(etapa) {
        var barra = '#barra-' + etapa;
        $(barra).removeClass('progress-bar-primary active progress-bar-warning progress-bar-danger').addClass('progress-bar-success');
    }

    function mudaTexto(etapa, texto) {
        var campo = '#resultado-' + etapa;
        $(campo).html(texto);
    }

    function erroTexto(etapa, texto) {
        var campo = '#resultado-' + etapa;
        $(campo).append(texto);
    }

    // Escreve as mensagens mais recentes para o usuário.
    $.get("/Transportes/backend/web/ajax/mensagens", function (data) {
        $.each(data, function (key, value) {

            var lista = '<li><a href="/Transportes/backend/web/site/mensagens?id=' + value.id + '"><div class="pull-left"><img src="/Transportes/backend/web/img/sistema/avatar.png" class="img-circle" alt="User Image" /></div><h4>LND Sistemas<small><i class="fa fa-clock-o"></i>' + value.data + '</small></h4><p>' + value.titulo + '</p></a></li>';

            $("#menuTopo").append(lista);

        });
    });


});