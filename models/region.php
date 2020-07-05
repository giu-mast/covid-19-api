<?php

define("COLUMNS",array("date","nation","region_code","region_name","latitude","longitude","hospitalized_with_symptoms","intensive_care","total_hospitalized","home_isolation","total_positives","total_variation_positives","new_positives","released_cured","total_deaths","total_cases","swabs","testes_cases", "screening_cases", "diagnostic_suspect_cases"));
define("PATH_CSV",$_SERVER['DOCUMENT_ROOT']."/COVID-19/dati-regioni/dpc-covid19-ita-regioni.csv");
if (!defined('E_LOG_PATH')) define("E_LOG_PATH",$_SERVER["DOCUMENT_ROOT"]."/log_errors.txt");;


class Region{
    
    private $csvreader;
    private $jsonadapter;
    public $results_array;
    public $headers;
    
    public function __construct(){
        try{
             $this->csvreader = new CSVReader(PATH_CSV);
             if(!$this->csvreader->columns_replace(COLUMNS)){
                $columns = var_export(COLUMNS, true);
                $headers = var_export($this->csvreader->headers, true);

                throw new Exception("Columns Error: -> unable to replace key fields.\n" . $headers . "\n" . $columns . "\n");
             }
             $this->results_array = $this->csvreader->get_results();
             $this->headers = $this->csvreader->get_headers();
        }catch(Exception $e){
            $current_date = new DateTime();
            $this->jsonadapter = new JSONAdapter(array("Error_message"=>$e->getMessage()));
            $fileError = fopen(E_LOG_PATH,"a");
            fwrite($fileError,"\n\n[models -> regions] [date->".$current_date->format('Y-m-d H:i:s')."] [client_IP->".getUserIpAddr()."]" . $e->getMessage() . "\n\n");
            fclose($fileError);
            throw $e;
        }
    }
    
    public function get_all($start_date=false, $single=false, $end_date=false){
        if($start_date == false){$start_date = $this->get_max_date();}
        if($end_date == false){$end_date = $this->get_max_date();}
        if($single == true){
            if(strtotime($start_date) >= strtotime("2020-02-24") && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results_array as $item){
                    if(strtotime($start_date) == strtotime($item[$this->headers[0]])){
                        $all[] = $item;
                    }
                }
                $this->jsonadapter = new JSONAdapter($all);
                return $this->jsonadapter->get_json();  
            }
            else{
                return false;
            }
        }
        else{ 
            if((strtotime($end_date) >= strtotime($start_date)) && strtotime($end_date) >= strtotime("2020-02-24") && strtotime($start_date) >= strtotime("2020-02-24") && strtotime($end_date) <= strtotime($this->get_max_date()) && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results_array as $item){
                    $date = strtotime($item[$this->headers[0]]);
                    if($date >= strtotime($start_date) && $date <= strtotime($end_date)){
                        $all[] = $item;
                    }
                }
                $this->jsonadapter = new JSONAdapter($all);
                return $this->jsonadapter->get_json();
            }   
            else{
                return false;
            }
        }
   }
    
   public function get_max_date(){
        $max_date = null;
        foreach($this->results_array as $item){
            if(!$max_date){
                $max_date = strtotime($item[$this->headers[0]]);
            }
            else{
                $temp = strtotime($item[$this->headers[0]]);
                if($temp > $max_date){
                    $max_date = $temp;
                }
            }
        }
        return date("Y-m-d", $max_date);
   }
    
   public function filtered_get_regions($start_date=false, $single=false, $end_date=false, $region_code=false, $region_name=false){
        if($start_date == false){$start_date = $this->get_max_date();}
        if($end_date == false){$end_date = $this->get_max_date();}
        if($region_code == false){
            $region_code = array();
        }
        if($region_name == false){
            $region_name = array();
        }
        else{
            foreach($region_name as &$element){
                $element = strtoupper($element);
            }
        }

        if($single == true){
            if(strtotime($start_date) >= strtotime("2020-02-24") && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results_array as $item){
                    if(sizeof($region_code) == 0 && sizeof($region_name) == 0){
                        if(strtotime($start_date) == strtotime($item[$this->headers[0]])){
                            $all[] = $item;
                        }
                    }
                    else{
                        if(strtotime($start_date) == strtotime($item[$this->headers[0]]) && (in_array($item[$this->headers[2]],$region_code) ||  in_array(strtoupper($item[$this->headers[3]]),$region_name))){
                            $all[] = $item;
                        }
                    }
                }
                if(sizeof($all)==0){
                    $this->jsonadapter = new JSONAdapter(array("Empty_search"=>"Nothing was found"));
                    return $this->jsonadapter->get_json();
                }
                else{
                    $this->jsonadapter = new JSONAdapter($all);
                    return $this->jsonadapter->get_json();
                }
            }
            else{
                return false;
            }
        }
        else{
            $cond = (strtotime($end_date) >= strtotime($start_date)) && strtotime($end_date) >= strtotime("2020-02-24") && strtotime($start_date) >= strtotime("2020-02-24") && strtotime($end_date) <= strtotime($this->get_max_date()) && strtotime($start_date) <= strtotime($this->get_max_date());

            if($cond){
                $all = array();
                foreach($this->results_array as $item){
                    if(sizeof($region_code) == 0 && sizeof($region_name) == 0){
                        $date = strtotime($item[$this->headers[0]]);
                        if($date >= strtotime($start_date) && $date <= strtotime($end_date)){
                            $all[] = $item;
                        }
                    }
                    else{
                        $date = strtotime($item[$this->headers[0]]);
                        if(($date >= strtotime($start_date) && $date <= strtotime($end_date)) && (in_array($item[$this->headers[2]],$region_code) || in_array(strtoupper($item[$this->headers[3]]),$region_name))){
                            $all[] = $item;
                        }
                    }
                }
                if(sizeof($all)==0){
                    $this->jsonadapter = new JSONAdapter(array("Empty_search"=>"Nothing was found"));
                    return $this->jsonadapter->get_json();
                }
                else{
                    $this->jsonadapter = new JSONAdapter($all);
                    return $this->jsonadapter->get_json();
                }
            }   
            else{
                return false;
            } 
        }
   }

   public function get_error_json($array){
      $this->jsonadapter = new JSONAdapter($array);
      return $this->jsonadapter->get_json();
   }
    
    public function __destruct(){
      $this->csvreader = null;
      $this->jsonadapter = null;
      $this->results_array = null;
      $this->headers = null;
    }
    
}

?>