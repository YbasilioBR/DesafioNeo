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

function OrderBy($array,$key,$ascdesc) {
	
	foreach($array as $k=>$v) {
	   $b[] = $v[$key];
	}
        
        if($ascdesc == 'asc'){
           asort($b);
        }else{
           arsort($b);
        }
	
	foreach($b as $k=>$v) {
           $c[] = $array[$k];
	}
	
        return $c;
        
}

function objectToArray($d) {
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