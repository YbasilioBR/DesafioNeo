<?php

function AcessaBase(){

$url = '..\Dados\tickets.json'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$tickets = json_decode($data); // decode the JSON feed

return($tickets);

}