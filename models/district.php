<?php
class District{
  
  // database connection and table name
  private $csvreader;
  private $jsonadapter;

  // object properties
  public $data;
  public $codice_provincia;
  public $denominazione_provincia;
  /*....*/
  public $deceduti;
  public $totale_ospedalizzati;
  /* etc etc */

  // constructor with $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }

  function create(){
  }
  function read($filter){
    /* Sia l'algoritmo per restituire tutte le istanze sia l'algoritmo per restituirne una o restituire un sottoinsieme di esse */
    if($filter){
      /* eseguo il filtraggio */
    }else{
      /* restituisco tutte le righe del csv serializzate in JSON */
    }
  }
  function update(){
  
  }
  function delete(){
    
  }
}
?>
