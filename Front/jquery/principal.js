$(document).ready(function(){

   var $pagination = 0;      
   $pagination =  $("#perPage").val(); //Recebe a quantidade por paginas
    
   $('#paginas option[value='+$pagination+']').attr('selected','selected'); //Deixa selecionado no combo o numero de itens por pagina 
   
   $("#paginas").change(function(){  //Quanto trocar a quantidade por pagina
       var $pagination = 0;      
       $pagination =  $( "#paginas" ).val(); //Recebe a nova quantidade

       window.location.href = "Principal.php?ItensPorPagina="+$pagination; //Redirecionado passando o numero de itens por pagina
    });


 });