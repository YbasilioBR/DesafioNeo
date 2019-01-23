<?php
require_once "..\DAO\DAO.Ticket.php";

$pagina = 1;
$order = "";

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
}

if (isset($_GET["order"])) {
  $order = $_GET["order"];
}

$objDao = new TicketDAO();
$objTickets = new Ticket();

$objDao->UpdateTickets();
$objTickets = $objDao->GetTickets($order);
$pages = count($objTickets)/5;

$output = array_slice($objTickets, ($pagina*$pages)-5, $pages);

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
    <script src="jquery/principal.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

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
  <?php foreach ($output as $ticket) { ?>
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
<ul class="pagination">
  <?php for ($p = 1; $p <= $pages; $p++){?>
    <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($p);?>"> <?php echo($p);?> </a></li>
  <?php }?>
  </ul>
</div>

  </body>

</html>
