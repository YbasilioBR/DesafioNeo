<?php
require_once "..\DAO\DAO.Ticket.php";

$objDao = new TicketDAO();
$objTickets = new Ticket();

$objDao->UpdateTickets();
$objTickets = $objDao->GetTickets();

?>

<!DOCTYPE html>
<html lang="pt-br">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


    

    <script src="jquery\principal.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Tickets for answer</title>

  </head>

  <body style="padding-top: 50px;">

    <nav class="navbar fixed-top navbar-light bg-light">
        <a class="navbar-brand" href="#">Tickets for answer</a>
    </nav>  

    <div>

<table class="table table-dark" id="tableDados">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">ID Categoria</th>
      <th scope="col">ID Cliente</th>
      <th scope="col">Cliente</th>
      <th scope="col">Email</th>
      <th scope="col">Data</th>
      <th scope="col">Data Atualização</th>
      <th scope="col">Prioridade</th>
      <th scope="col">Interações</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($objTickets as $ticket) { ?>
    <tr>
      <th scope="row"><?php echo($ticket->TicketID); ?></th>      
      <td><?php echo($ticket->CategoryID); ?></td>
      <td><?php echo($ticket->CustomerID); ?></td>
      <td><?php echo($ticket->CustomerName); ?></td> 
      <td><?php echo($ticket->CustomerEmail); ?></td>
      <td><?php echo(date('d/m/Y', strtotime($ticket->DateCreate))); ?></td>
      <td><?php echo(date('d/m/Y', strtotime($ticket->DateUpdate))); ?></td>
      <td><?php echo($ticket->Ranking); ?></td> 
      <td>X</td>
    </tr>

    <?php } ?>
  </tbody>
</table>

</div>

  </body>

</html>
