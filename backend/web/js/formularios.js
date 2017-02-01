/**
 * Script em jQuery com funções para formulários
 * 
 * A principal e mais usada é a que troca de campos
 * usando o "Enter" ou "TAB"
 */

$(document).ready(function(){
	
	// Verifica todos os campos tipo "text"
	// e possibilita avancar campos usando o 'Enter'
	$('input:text, select').keypress(function(e) {
		 if(e.which==13){
			 textboxes = $("input,select");
			 currentBoxNumber = textboxes.index(this);
			 if (textboxes[currentBoxNumber + 1] != null){
				 nextBox = textboxes[currentBoxNumber + 1]
				 nextBox.focus();
				 e.preventDefault();
			 }
		 } else {
			 return true;
		 }
	});
   
});