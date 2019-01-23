<?php

function AcessaBase(){

$url = '..\Dados\tickets.json';
$data = file_get_contents($url);
$tickets = json_decode($data);

return($tickets);

}

function AtualizaDados(array $newTickets)
{
        $newTicketsJson = json_encode($newTickets, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

        $arquivo = "../Dados/tickets.json";

        $atualiza = fopen($arquivo, "w+");

        fwrite($atualiza, $newTicketsJson);

        fclose($atualiza);
}