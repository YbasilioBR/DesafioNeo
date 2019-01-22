$(document).ready(function(){
    $.ajax({
        type: 'GET',
        url: '..\3 - DAO\DAO.Ticket.php',
        success: function(data) {
            alert(data); 
        }
    });
})