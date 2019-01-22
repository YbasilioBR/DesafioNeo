<?php

class Ticket{

   public $TicketID;
   public $CategoryID;
   public $CustomerID;
   public $CustomerName;
   public $CustomerEmail;
   public $DateCreate;
   public $DateUpdate;   
   public $Interactions = array('subject' => "", 'message' => "", 'DateCreate' => "", 'Sender' => "");
   public $Ranking;

}

?>