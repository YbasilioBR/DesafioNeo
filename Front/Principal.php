<?php
require_once "..\DAO\DAO.Ticket.php";

$pagina = 1; // Variavel de contagem de paginas para os itens
$dados = array(); //array para dados, cada posição de acordo com a pagina é uma posição inicial para o array_slice
$dados[0] = 0; //Inicia array com a posição 0 valendo 0
$ItensPorPagina = 0; //Variavel para o numero de itens por pagina
$order = ""; //Variavel para receber o tipo de ordenação Asc ou desc
$campoOrder = ""; //Campo que será baseada a ordenação
$numPaginas = 0; //Vriavel para o numero de paginas para os itens

if (isset($_GET["pagina"])) { //Se receber um get para paginas, atribui a variavel
  $pagina = $_GET["pagina"];
}

if (isset($_GET["order"])) { //Se receber um get para order, atribui a variavel
  $order = $_GET["order"];
}

if (isset($_GET["campoOrder"])) { //Se receber um get para campoOrder, atribui a variavel
  $campoOrder = $_GET["campoOrder"];
}

if (isset($_GET["ItensPorPagina"])) { //Se receber um get para ItensPorPagina, atribui a variavel, senão deixa o padrão que é o tamanho do array
  $ItensPorPagina = $_GET["ItensPorPagina"];
}else{
  $ItensPorPagina = 25;
}

$objDao = new TicketDAO(); //Objeto da classe dao tickets
$objTickets = new Ticket(); //Objeto da classe tickets

$objDao->UpdateTickets(); //Classifica a prioridade dos tickets
$objTickets = $objDao->GetTickets($campoOrder,$order); //o objeto tickets recebe os dados dos tickets

while($itens < count($objTickets)){ //enquanto itens for menor que a quantidade dos tickets
    $itens += $ItensPorPagina; //Recebe a quantidade de itens por pagina definido no combo box
    $numPaginas += 1; //Aumenta o numero de paginas por quantidade de itens
    $dados[$numPaginas] = $itens; //Implementa a quantidade para a pagina no array
}

$output = array_slice($objTickets, $dados[$pagina-1] , $ItensPorPagina); //Outpur recebe o intervalo de array que foi definido por pagina

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
        <a href="Principal.php?campoOrder=DateCreate&order=desc&ItensPorPagina=<?php echo($ItensPorPagina);?>"><i class="fa fa-caret-up  hidden" data-order="up"></i></a>
        <a href="Principal.php?campoOrder=DateCreate&order=asc&ItensPorPagina=<?php echo($ItensPorPagina);?>"><i class="fa fa-caret-down  hidden" data-order="down"></i></a> 
      </th>
      <th style="text-align:center" >Data Atualização 
        <a href="Principal.php?campoOrder=DateUpdate&order=desc&ItensPorPagina=<?php echo($ItensPorPagina);?>"><i class="fa fa-caret-up  hidden" data-order="up"></i></a>
        <a href="Principal.php?campoOrder=DateUpdate&order=asc&ItensPorPagina=<?php echo($ItensPorPagina);?>"><i class="fa fa-caret-down  hidden" data-order="down"></i></a> 
      </th>
      <th style="text-align:center">Prioridade 
        <a href="Principal.php?campoOrder=Ranking&order=asc&ItensPorPagina=<?php echo($ItensPorPagina);?>"><i class="fa fa-caret-up  hidden" data-order="up"></i></a>
        <a href="Principal.php?campoOrder=Ranking&order=desc&ItensPorPagina=<?php echo($ItensPorPagina);?>"><i class="fa fa-caret-down  hidden" data-order="down"></i></a> 
      </th>
      <th style="text-align:center">N° Interações</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($output as $ticket) { ?> <!-- Exibe os dados do array por pagina -->
    <tr>
      <th style="text-align:center"><?php echo($ticket->TicketID); ?></th>      
      <td style="text-align:center"><?php echo($ticket->CategoryID); ?></td>
      <td style="text-align:center"><?php echo($ticket->CustomerID); ?></td>
      <td style="text-align:center"><?php echo($ticket->CustomerName); ?></td> 
      <td style="text-align:center"><?php echo($ticket->CustomerEmail); ?></td>
      <td style="text-align:center"><?php echo(date('d/m/Y', strtotime($ticket->DateCreate))); ?></td>
      <td style="text-align:center"><?php echo(date('d/m/Y', strtotime($ticket->DateUpdate))); ?></td>
      <td style="<?php echo($ticket->Ranking == 'Alta' ? "text-align:center;color:red" : "text-align:center;color:blue");?>"><?php echo($ticket->Ranking); ?></td> 
      <td style="text-align:center"><?php echo(count($ticket->Interactions)); ?></td>
    </tr>

    <?php } ?>
  </tbody>
</table>
</div>

<div class="row">
<div class="col-md-1">

    <select class="form-control" id="paginas"> <!-- Select com a quantidade por pagina -->
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
    </select>

  </div>
  <div class="col"> 
    <ul class="pagination">  <!-- Cria os links para as paginas -->
      <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($pagina-1 > 0 ? $pagina-1 : 1);?>&ItensPorPagina=<?php echo($ItensPorPagina);?>"><<</a></li>
        <?php for ($p = 1; $p <= $numPaginas; $p++){?>
          <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($p);?>&ItensPorPagina=<?php echo($ItensPorPagina);?>"> <?php echo($p);?> </a></li>
        <?php }?>
      <li class="page-item"><a class="page-link" href="Principal.php?pagina=<?php echo($pagina+1 > $numPaginas ? $numPaginas : $pagina+1);?>&ItensPorPagina=<?php echo($ItensPorPagina);?>">>></a></li>
    </ul>
  </div>
</div>

<input type="hidden" id="perPage" value="<?php echo($ItensPorPagina);?>"> <!-- Armazena a quantidade por pagina, para o JS acessar -->

</body>

</html>
