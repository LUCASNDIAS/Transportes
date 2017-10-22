<html>
    <head>
        <title>Validador</title>
        <script src="/Transportes/backend/web/assets/bd6fb587/jquery.js"></script>
        <script>
            $(document).ready(function () {

                $("#validar").on('click', function () {
                    var xml = $("textarea").val();
                    ShemaXML(xml);
                });

                function ShemaXML(xml) {
                    var txtSub = "Validar";
                    var proxy = "https://cors-anywhere.herokuapp.com/";
                    var myUrl = "https://www.sefaz.rs.gov.br/ASP/AAE_ROOT/CTE/SAT-WEB-CTE-VAL_1.asp";

                    var request = $.ajax({
                        url: proxy + myUrl,
                        method: "POST",
                        data: {txtCte: xml, submit1: txtSub},
                        dataType: 'html'
                    }).done(function (html) {
                        $("#oculto").append(html);
                        resultadoShema();
                    });

                }

                function resultadoShema() {
                    var resultado = $("#oculto").find('.tdVal:last').html();
                    $("#results").html(resultado);
                }

            });
        </script>
    </head>
    <body>
        <div id="validar">Validar</div>
        <textarea style="border: 1px solid Gray; color: black;" cols="105" rows="15" name="txtCTe"><?xml version="1.0" encoding="utf-8"?>
<CTe xmlns="http://www.portalfiscal.inf.br/cte"><infCte Id="CTe31170911095658000140570010000003421098357832" versao="2.00"><ide><cUF>31</cUF><cCT>09835783</cCT><CFOP>5932</CFOP><natOp>SERVICO DE TRANSPORTE FORA DA SEDE DA TRANSPORTADORA</natOp><forPag>2</forPag><mod>57</mod><serie>1</serie><nCT>342</nCT><dhEmi>2017-09-19T10:50:31</dhEmi><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>2</tpAmb><tpCTe>0</tpCTe><procEmi>0</procEmi><verProc>2.0</verProc><cMunEnv>3154606</cMunEnv><xMunEnv>RIBEIRAO DAS NEVES</xMunEnv><UFEnv>MG</UFEnv><modal>01</modal><tpServ>0</tpServ><cMunIni>3106200</cMunIni><xMunIni>BELO HORIZONTE</xMunIni><UFIni>MG</UFIni><cMunFim>3154606</cMunFim><xMunFim>RIBEIRAO DAS NEVES</xMunFim><UFFim>MG</UFFim><retira>1</retira><toma03><toma>0</toma></toma03></ide><emit><CNPJ>11095658000140</CNPJ><IE>0013712160020</IE><xNome>ELIAS TRANSPORTES RAPIDOS</xNome><xFant>ELIAS TRANSPORTES RAPIDOS</xFant><enderEmit><xLgr>RUA SEVILHA</xLgr><nro>202</nro><xBairro>SAN REMO</xBairro><cMun>3154606</cMun><xMun>RIBEIRAO DAS NEVES</xMun><CEP>33836310</CEP><UF>MG</UF><fone>31975899098</fone></enderEmit></emit><rem><CPF>09835783624</CPF><IE>ISENTO</IE><xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome><fone>31987796794</fone><enderReme><xLgr>RUA O ATENEU</xLgr><nro>144</nro><xBairro>CONJUNTO ADEMAR MALDONADO (BARREIRO)</xBairro><cMun>3106200</cMun><xMun>BELO HORIZONTE</xMun><CEP>30640780</CEP><UF>MG</UF><cPais>1058</cPais><xPais>BRASIL</xPais></enderReme><email>diasnlucas@gmail.com</email></rem><dest><CNPJ>11095658000140</CNPJ><IE>0013712160020</IE><xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome><fone>31975899098</fone><enderDest><xLgr>RUA SEVILHA</xLgr><nro>202</nro><xBairro>SAN REMO</xBairro><cMun>3154606</cMun><xMun>RIBEIRAO DAS NEVES</xMun><CEP>33836310</CEP><UF>MG</UF><cPais>1058</cPais><xPais>BRASIL</xPais></enderDest><email>eliastransportesrapidos@gmail.com</email></dest><vPrest><vTPrest>44.16</vTPrest><vRec>44.16</vRec><Comp><xNome>DESPACHO</xNome><vComp>1.50</vComp></Comp><Comp><xNome>FRETE PESO</xNome><vComp>2.66</vComp></Comp><Comp><xNome>FRETE MINIMO</xNome><vComp>40.00</vComp></Comp></vPrest><imp><ICMS><ICMS90><CST>90</CST><vBC>44.16</vBC><pICMS>5.25</pICMS><vICMS>2.32</vICMS></ICMS90></ICMS><vTotTrib>2.32</vTotTrib></imp><infCTeNorm><infCarga><vCarga>3332.43</vCarga><proPred>ROUPAS</proPred><xOutCat>CAIXAS</xOutCat><infQ><cUnid>01</cUnid><tpMed>PESO BRUTO</tpMed><qCarga>12.3500</qCarga></infQ><infQ><cUnid>01</cUnid><tpMed>PESO CUBADO</tpMed><qCarga>57.6000</qCarga></infQ><infQ><cUnid>03</cUnid><tpMed>VOLUMES</tpMed><qCarga>8.0000</qCarga></infQ><infQ><cUnid>01</cUnid><tpMed>PESO BRUTO</tpMed><qCarga>12.3500</qCarga></infQ><infQ><cUnid>01</cUnid><tpMed>PESO CUBADO</tpMed><qCarga>57.6000</qCarga></infQ><infQ><cUnid>03</cUnid><tpMed>VOLUMES</tpMed><qCarga>8.0000</qCarga></infQ></infCarga><infDoc><infNF><nRoma>1234</nRoma><nPed>1234</nPed><mod>04</mod><serie>1</serie><nDoc>12345</nDoc><dEmi>2017-09-19</dEmi><vBC>0</vBC><vICMS>0</vICMS><vBCST>0</vBCST><vST>0</vST><vProd>3332.43</vProd><vNF>3332.43</vNF><nCFOP>5990</nCFOP><nPeso>12.345</nPeso></infNF></infDoc><seg><respSeg>5</respSeg></seg><infModal versaoModal="2.00"><rodo><RNTRC>1234123423</RNTRC><dPrev>2017-09-28</dPrev><lota>0</lota></rodo></infModal></infCTeNorm></infCte><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI="#CTe31170911095658000140570010000003421098357832"><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>P6Hbz4tgKSw1I97Y7Plu8mG4c0s=</DigestValue></Reference></SignedInfo><SignatureValue>rFlLFgEUYK/yEGWm6mnqeuX5Z/JoQzzy4zK0s07xPv7QsvePWVS40YUrp9QpRFsBzY95/PS/VaYCueFtrZZg0ejjA5M6ww33l7+crfxHg90d2V1czJm6Zk37v6gg95Qcl6/z858foGPJpkzhcvE92mHNcaVKep1JyN/jdOQ9Rz0c99bLuIBa1odvNyBEICB+8T+fUl1yZGw4IXyYGfs/hge8/RoyeYNGVjp3TUnOc4BkqcXwGqGqkd5+X+cwEQKBbb+l/JJ0gGIgaOK5S3HhwQmPNQuvMR0zek7l34FIgDs00thplwuKUpw95ZfcrnA3/k8AG6hrbY4LOdIx9us1wg==</SignatureValue><KeyInfo><X509Data><X509Certificate>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</X509Certificate></X509Data></KeyInfo></Signature></CTe>
        </textarea>
        <div id="tbl-resultado">Tabela: </div>
        <div id="results">Resultado: </div>
        <div id="oculto">Hided: </div>
    </body>
</html>