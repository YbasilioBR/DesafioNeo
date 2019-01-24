<?php
require_once "..\DAO\DAO.Ticket.php";

$pagina = 1;
$paginacao = 25;
$order = "";
$campoOrder = "";

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
}

if (isset($_GET["order"])) {
  $order = $_GET["order"];
}

if (isset($_GET["campoOrder"])) {
  $campoOrder = $_GET["campoOrder"];
}

if (isset($_GET["campoOrder"])) {
  $campoOrder = $_GET["campoOrder"];
}

$objDao = new TicketDAO();
$objTickets = new Ticket();

$objDao->UpdateTickets();
$objTickets = $objDao->GetTickets($campoOrder,$order);
$pages = count($objTickets)/$paginacao;

$output = array_slice($objTickets, ($pagina-1) * 5, $paginacao);

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

  <body style="padding-top: 75px;margin-left: 25px;margin-right: 25px;background-color: black;">

    <nav class="navbar fixed-top navbar-light bg-light" style="margin-left: 25px;margin-right: 25px;">
        <a class="navbar-brand" href="#">Tickets for answer</a>
    </nav>  

    <div>

<table class="table table-light" id="tableDados">
  <thead>
    <tr>
      <th style="text-align:center">ID</th>
      <th style="text-align:center">ID Categoria</th>
      <th style="text-align:center">ID Cliente</th>
      <th style="text-align:center">Cliente</th>
      <th style="text-align:center">Email</th>
      <th style="text-align:center" >Data Criação
        <a href="Principal.php?campoOrder=DateCreate&order=desc"><i class="fa fa-caret-up  hidden" data-order="up"></i></a>
        <a href="Principal.php?campoOrder=DateCreate&order=asc"><i class="fa fa-caret-down  hidden" data-order="down"></i></a> 
      </th>
      <th style="text-align:center" >Data Atualização 
        <a href="Principal.php?campoOrder=DateUpdate&order=desc"><i class="fa fa-caret-up  hidden" data-order="up"></i></a>
        <a href="Principal.php?campoOrder=DateUpdate&order=asc"><i class="fa fa-caret-down  hidden" data-order="down"></i></a> 
      </th>
      <th style="text-align:center">Prioridade 
        <a href="Principal.php?campoOrder=Ranking&order=asc"><i class="fa fa-caret-up  hidden" data-order="up"></i></a>
        <a href="Principal.php?campoOrder=Ranking&order=desc"><i class="fa fa-caret-down  hidden" data-order="down"></i></a> 
      </th>
      <th style="text-align:center">Interações</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($output as $ticket) { ?>
    <tr>
      <th style="text-align:center"><?php echo($ticket->TicketID); ?></th>      
      <td style="text-align:center"><?php echo($ticket->CategoryID); ?></td>
      <td style="text-align:center"><?php echo($ticket->CustomerID); ?></td>
      <td style="text-align:center"><?php echo($ticket->CustomerName); ?></td> 
      <td style="text-align:center"><?php echo($ticket->CustomerEmail); ?></td>
      <td style="text-align:center"><?php echo(date('d/m/Y', strtotime($ticket->DateCreate))); ?></td>
      <td style="text-align:center"><?php echo(date('d/m/Y', strtotime($ticket->DateUpdate))); ?></td>
      <td style="text-align:center"><?php echo($ticket->Ranking); ?></td> 
      <td style="text-align:center"><?php echo(count($ticket->Interactions)); ?></td>
    </tr>

    <?php } ?>
  </tbody>
</table>
</div>

<div class="row">
<div class="col-md-1">

    <select class="form-control" id="paginas">
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
    </select>

  </div>
  <div class="col">
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($pagina-1 > 0 ? $pagina-1 : 1);?>"><<</a></li>
        <?php for ($p = 1; $p <= $pages; $p++){?>
          <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($p);?>"> <?php echo($p);?> </a></li>
        <?php }?>
      <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($pagina+1 > $pages ? $pages : $pagina+1);?>">>></a></li>
    </ul>
  </div>
</div>

</body>

</html>
