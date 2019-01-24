$(document).ready(function(){

   var $pagination = 0;      
   $pagination =  $("#perPage").val();
    
   $('#paginas option[value='+$pagination+']').attr('selected','selected');
   
   $("#paginas").change(function(){ 
       var $pagination = 0;      
       $pagination =  $( "#paginas" ).val();

       window.location.href = "Principal.php?paginacao="+$pagination;
    });


 });