<?php

define("COLUMNS",array("date","Nation","region_code","region_name","province_code","province_denomination","province_abbreviation","latitude","longitude","total_cases"));
define("PATH_CSV","../../csv/dpc-covid19-ita-province.csv");

class District{
    
  private $csvreader;
  private $jsonadapter;
  public $results_array;
  public $headers;



  public function __construct(){
     try{
         $this->csvreader = new CSVReader(PATH_CSV);
         if(!$this->csvreader->columns_replace(COLUMNS)){
             throw new Exception("Columns Error: -> unable to replace key fields.");
         }
         $this->results_array = $this->csvreader->get_results();
         $this->headers = $this->csvreader->get_headers();
     }catch(Exception $e){
         $this->jsonadapter = new JSONAdapter(array("Error_message"=>$e));
         $this->jsonadapter->get_json();
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
        return date("Y-m-d",$max_date);
  }
    
  public function filtered_get_districts($start_date=false, $single=false, $end_date=false, $district_code=false, $district_name=false){
        if($start_date == false){$start_date = $this->get_max_date();}
        if($end_date == false){$end_date = $this->get_max_date();}
        if($district_code == false){
            $district_code = array();
        }
        if($district_name == false){
            $district_name = array();
        }
        else{
            foreach($district_name as &$element){
                $element= strtoupper($element);
            }
        }
        if($single == true){
            if(strtotime($start_date) >= strtotime("2020-02-24") && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results_array as $item){
                    if(sizeof($district_code) == 0 && sizeof($district_name) == 0){
                        if(strtotime($start_date) == strtotime($item[$this->headers[0]])){
                            $all[] = $item;
                        }
                    }
                    else{
                        if((strtotime($start_date) == strtotime($item[$this->headers[0]])) && (in_array($item[$this->headers[6]],$district_name) || in_array($item[$this->headers[4]],$district_code))){
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
            if((strtotime($end_date) >= strtotime($start_date)) && strtotime($end_date) >= strtotime("2020-02-24") && strtotime($start_date) >= strtotime("2020-02-24") && strtotime($end_date) <= strtotime($this->get_max_date()) && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results_array as $item){
                    if(sizeof($district_code) == 0 && sizeof($district_name) == 0){
                        $date = strtotime($item[$this->headers[0]]);
                        if($date >= strtotime($start_date) && $date <= strtotime($end_date)){
                            $all[] = $item;
                        }
                    }
                    else{
                        $date = strtotime($item[$this->headers[0]]);
                        if(($date >= strtotime($start_date) && $date <= strtotime($end_date)) && (in_array($item[$this->headers[4]],$district_code) || in_array($item[$this->headers[6]],$district_name))){
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
