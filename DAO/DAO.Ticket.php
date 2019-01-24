<?php

include "..\Classes\Class.Ticket.php";
require_once "..\Dados\dados.php";

interface ITicket{
    public function GetTickets($campoOrder,$order);
    public function UpdateTickets();
}

class TicketDAO implements ITicket 
{
    function GetTickets($campoOrder,$order)
    {

        $tickets = AcessaBase();

        if($campoOrder !== ""){ //Se ouver um campo recebido para ordenar, chama o método de ordenação, senão traz os dados normalmente
            $Arrtickets = OrderBy(objectToArray($tickets),$campoOrder,$order);
        }else{
            $Arrtickets = objectToArray($tickets);
        }
       

        $objTickets[] = new Ticket();  //Cria um array de objetos da classe Ticket      
        $i = 0;

        foreach ($Arrtickets as $value) {
         
            $objTicket = new Ticket(); //Cria objeto da classe Ticket para receber os dados da posição atual do array
            $objTicket->TicketID        = $value['TicketID'];
            $objTicket->CategoryID      = $value['CategoryID'];
            $objTicket->CustomerID      = $value['CustomerID'];
            $objTicket->CustomerName    = $value['CustomerName'];
            $objTicket->CustomerEmail   = $value['CustomerEmail'];
            $objTicket->DateCreate      = $value['DateCreate'];
            $objTicket->DateUpdate      = $value['DateUpdate'];
            $objTicket->Interactions    = $value['Interactions'];
            $objTicket->Ranking         = $value['Ranking'];

            $objTickets[$i] = $objTicket; //Passa o objeto para a posição atual do array de objetos
            $i++;
        }
        
       return($objTickets); //Retorna o array de objetos

    }

    function UpdateTickets(){ //Função para classificar os tickets

        $arrTickets = AcessaBase(); //Recebe os dados dos tickets
        $objTicket = new Ticket(); //Cria objeto da classe Ticket
        $objTickets[] = new Ticket(); //Cria um array de objetos da classe Ticket

        for ($i = 0; $i < count($arrTickets); $i++) {

            $objTicket = $arrTickets[$i]; //o objeto recebe os dados da posição atual

            $dias = 0; //Variavel flag para receber se os dias do inicio até o ultimo atendimento foi grande
            $interacoes = 0; //Variavel flag para receber se o numero de interações foi mais de um
            $insatisfacao = 0; //Variavel flag para receber se o cliente está insatisfeito

            $dataInicio = date_create($arrTickets[$i]->DateCreate); //Data de inicio do ticket
            $dataFim = date_create($arrTickets[$i]->DateUpdate); //Data da ultima atualização

            $diasResolucao = date_diff($dataInicio, $dataFim); //Intervalo de dias entre as datas

            if ($diasResolucao->days > 30) { //Se o intervalo for maior que 30, marca a flag do prazo alto
                $dias = 1;
            }

            if (count($arrTickets[$i]->Interactions) >= 2) { //Se as interações forem maiores ou igual a, marca a flag de mais de uma interação
                $interacoes = 1;
            }

            foreach ($arrTickets[$i]->Interactions as $value) { //For para varrer as interações do ticket atual

            if (strpos($value->Subject, 'Reclamação') !== false ||
                strpos($value->Subject, 'Troca') !== false ||
                strpos($value->Subject, 'Solução') !== false) { //Verifica no assunto se contém as palavras seguintes que possam denotar insatisfação do cliente e se sim, marca a flag

                $insatisfacao = 1;
            }

            if (strpos($value->Message, 'Reclamação') !== false ||
                strpos($value->Message, 'Troca') !== false ||
                strpos($value->Message, 'Solução') !== false ||
                strpos($value->Message, 'Mas')) { //Verifica no escopo da mensagem se contém as palavras seguintes que possam denotar insatisfação do cliente, marca a flag

                $insatisfacao = 1;

            }
        }

        if ($dias && $interacoes && $insatisfacao) { //Se todas as flags foram marcadas, o ticket é de prioridade alta, senão a prioridade é normal
            $objTicket->Ranking = "Alta";
        } else {
            $objTicket->Ranking = "Baixa";
        }

            $objTickets[$i] = $objTicket; //Array de objetos ticket recebe o ticket já classificado
        }

        AtualizaDados($objTickets); //Grava no tickets.json os dados atualizados e classificados

    }
}
