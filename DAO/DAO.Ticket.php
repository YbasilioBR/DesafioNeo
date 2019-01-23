<?php

include "..\Classes\Class.Ticket.php";
require_once "..\Dados\dados.php";

interface ITicket{
    public function GetTickets();
    public function UpdateTickets();
}

class TicketDAO implements ITicket 
{
    function GetTickets()
    {

        $tickets = AcessaBase();
        $objTickets[] = new Ticket();

        for ($i = 0; $i < count($tickets); $i++) {

            $objTickets[$i] = $tickets[$i];
        }

        return ($objTickets);

    }

    function UpdateTickets(){

        $arrTickets = AcessaBase();
        $objTicket = new Ticket();
        $objTickets[] = new Ticket();

        for ($i = 0; $i < count($arrTickets); $i++) {

            $objTicket = $arrTickets[$i];

            $dias = 0;
            $interacoes = 0;
            $insatisfacao = 0;
            $retorno = "";

            $dataInicio = date_create($arrTickets[$i]->DateCreate);
            $dataFim = date_create($arrTickets[$i]->DateUpdate);

            $diasResolucao = date_diff($dataInicio, $dataFim);

            if ($diasResolucao->days > 30) {
                $dias = 1;
            }

            if (count($arrTickets[$i]->Interactions) >= 2) {
                $interacoes = 1;
            }

            foreach ($arrTickets[$i]->Interactions as $value) {

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
            $objTicket->Ranking = "Alta";
        } else {
            $objTicket->Ranking = "Baixa";
        }

            $objTickets[$i] = $objTicket;
        }

        AtualizaDados($objTickets);

    }


    

}
