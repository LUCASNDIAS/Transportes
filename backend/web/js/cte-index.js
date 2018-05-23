/* 
 * Script jQuery com funções genéricas
 * usado em quase todas as páginas
 */

$(document).ready(function () {
    
    $('.cte-search').hide();

    $('#btn-pesquisar').on('click', function() {
        $('.cte-search').toggle('slow');
    });
    
    

});