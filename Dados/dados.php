<?php

function AcessaBase(){

$url = '..\Dados\tickets.json'; //Acessa o arquivo tickets.json
$data = file_get_contents($url); // Retira os dados
$tickets = json_decode($data); //Passa os dados para o formato Json

return($tickets);

}

function AtualizaDados(array $newTickets) //Método para acessar o arquivo atualizar com os novos dados recebidos no parametro $newTickets
{
        $newTicketsJson = json_encode($newTickets, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        $arquivo = "../Dados/tickets.json";
        $atualiza = fopen($arquivo, "w+");
        fwrite($atualiza, $newTicketsJson);
        fclose($atualiza);
}

function OrderBy($array,$key,$ascdesc) { //Serve para ordenar o array de acordo com o campo e o tipo de ordenação recebidos no parâmetro
	
	foreach($array as $k=>$v) {
	   $parcial[] = $v[$key];
	}
        
        if($ascdesc == 'asc'){
           asort($parcial);
        }else if($ascdesc == 'desc'){
           arsort($parcial);
        }
	
	foreach($parcial as $k=>$v) {
           $final[] = $array[$k];
	}
	
        return $final;
        
}

function objectToArray($d) { //Tranforma objeto em array (Para poder ordenar no método acima)
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
		
        if (is_array($d)) {  
            return array_map(__FUNCTION__, $d);
        }
        else {       
            return $d;
        }
}