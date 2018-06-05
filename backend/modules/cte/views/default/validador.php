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
        <textarea style="border: 1px solid Gray; color: black;" cols="105" rows="15" name="txtCTe">
        </textarea>
        <div id="tbl-resultado">Tabela: </div>
        <div id="results">Resultado: </div>
        <div id="oculto">Hided: </div>
    </body>
</html>