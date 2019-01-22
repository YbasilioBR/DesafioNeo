<?php

include "..\4 - Classes\Class.Ticket.php";
//include "..\Interface\Interface.Ticket.php";
require_once "..\5 - Dados\dados.php";

//class TicketDAO
//{
    function GetTickets()
    {

        $tickets = AcessaBase();
        $objTickets[] = new Ticket();

        for ($i = 0; $i < count($tickets); $i++) {

            $objTicket = new Ticket();

            $objTicket->TicketID = $tickets[$i]->TicketID;
            $objTicket->CategoryID = $tickets[$i]->CategoryID;
            $objTicket->CustomerID = $tickets[$i]->CustomerID;
            $objTicket->CustomerName = $tickets[$i]->CustomerName;
            $objTicket->CustomerEmail = $tickets[$i]->CustomerEmail;
            $objTicket->DateCreate = $tickets[$i]->DateCreate;
            $objTicket->DateUpdate = $tickets[$i]->DateUpdate;
            $objTicket->Interactions = $tickets[$i]->Interactions;
            $objTicket->Ranking = ClassificaTickets($objTicket);

            $objTickets[$i] = $objTicket;
        }

        AtualizaDados($objTickets);

        return (json_encode($objTickets));

    }

    function ClassificaTickets(object $arrTickets)
    {

        $dias = 0;
        $interacoes = 0;
        $insatisfacao = 0;
        $retorno = "";

        $dataInicio = date_create($arrTickets->DateCreate);
        $dataFim = date_create($arrTickets->DateUpdate);

        $diasResolucao = date_diff($dataInicio, $dataFim);

        if ($diasResolucao->days > 30) {
            $dias = 1;
        }

        if (count($arrTickets->Interactions) >= 2) {
            $interacoes = 1;
        }

        foreach ($arrTickets->Interactions as $value) {

            if (strpos($value->Subject, 'Reclamação') !== false ||
                strpos($value->Subject, 'Troca') !== false ||
                strpos($value->Subject, 'Solução') !== false) {

                $insatisfacao = 1;
            }

            if (strpos($value->Message, 'Reclamação') !== false ||
                strpos($value->Message, 'Troca') !== false ||
                strpos($value->Message, 'Solução') !== false ||
                strpos($value->Message, 'Mas')) {

                $insatisfacao = 1;

            }
        }

        if ($dias && $interacoes && $insatisfacao) {
            return "Alta";
        } else {
            return "Baixa";
        }
    }

    function AtualizaDados(array $newTickets)
    {
        $newTicketsJson = json_encode($newTickets, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

        $arquivo = "../Dados/tickets.json";

        $atualiza = fopen($arquivo, "w+");

        fwrite($atualiza, $newTicketsJson);

        fclose($atualiza);
    }

//}