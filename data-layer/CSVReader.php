<?php
class CSVReader{
    
    public $filecsv;  
    public $results;   
    public $headers;   
    
    public function __construct($filepath, $delimeter_c=",", $delimeter_r="\n", $enclosure='"', $escape="\\"){  
        if(!is_readable($filepath)){   
            throw new Exception("File Error:{$filepath} -> does not exist or is not readable."); 
        }
        else{
            if(($this->filecsv = file_get_contents($filepath)) !== false){
                $this->results = array();
                $this->headers = null;
                $csvtable = str_getcsv($this->filecsv,$delimeter_r,$enclosure,$escape);
                foreach($csvtable as $row){
                    if(!$this->headers){
                        $this->headers = str_getcsv($row,$delimeter_c,$enclosure,$escape);
                        $this->headers = array_slice($this->headers,0,sizeof($this->headers)-2);
                    }
                    else{
                        $row = substr_replace($row, '', 10, 9);
                        $row = str_replace("P.A.","",$row);
                        $row = str_getcsv($row,$delimeter_c,$enclosure,$escape);
                        $row = array_slice($row,0,sizeof($row)-2);
                        $this->results[] = array_combine($this->headers, $row);
                    }
                }
            }
            else{
                throw new Exception("File Error:{$filepath} -> cannot able to open and read file."); 
            }
        }
    }
    
    public function columns_replace($newkeys){
        if(sizeof($newkeys) == sizeof($this->headers)){
            $new_results = array();
            foreach($this->results as $item){
                $new_results[] = array_combine($newkeys, array_values($item));
            }
            $this->results = $new_results;
            $this->headers = $newkeys;
            return true;
        }
        else{
            return false;
        }
    }
    
    public function get_max_date(){
        $max_date = null;
        foreach($this->results as $item){
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
    
    public function filtered_get_districs($start_date=false, $single=false, $end_date=false, $district_code=false, $district_name=false){
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
                foreach($this->results as $item){
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
                return $all;
            }
            else{
                return false;
            }
        }
        else{
            if((strtotime($end_date) >= strtotime($start_date)) && strtotime($end_date) >= strtotime("2020-02-24") && strtotime($start_date) >= strtotime("2020-02-24") && strtotime($end_date) <= strtotime($this->get_max_date()) && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results as $item){
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
                return $all;
            }   
            else{
                return false;
            } 
        }
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
                foreach($this->results as $item){
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
                return $all;
            }
            else{
                return false;
            }
        }
        else{
            if((strtotime($end_date) >= strtotime($start_date)) && strtotime($end_date) >= strtotime("2020-02-24") && strtotime($start_date) >= strtotime("2020-02-24") && strtotime($end_date) <= strtotime($this->get_max_date()) && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results as $item){
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
                return $all;
            }   
            else{
                return false;
            } 
        }
    }
    
    public function get_all($start_date=false, $single=false, $end_date=false){
        if($start_date == false){$start_date = $this->get_max_date();}
        if($end_date == false){$end_date = $this->get_max_date();}
        if($single == true){
            if(strtotime($start_date) >= strtotime("2020-02-24") && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results as $item){
                    if(strtotime($start_date) == strtotime($item[$this->headers[0]])){
                        $all[] = $item;
                    }
                }
                return $all;
            }
            else{
                return false;
            }
        }
        else{ 
            if((strtotime($end_date) >= strtotime($start_date)) && strtotime($end_date) >= strtotime("2020-02-24") && strtotime($start_date) >= strtotime("2020-02-24") && strtotime($end_date) <= strtotime($this->get_max_date()) && strtotime($start_date) <= strtotime($this->get_max_date())){
                $all = array();
                foreach($this->results as $item){
                    $date = strtotime($item[$this->headers[0]]);
                    if($date >= strtotime($start_date) && $date <= strtotime($end_date)){
                        $all[] = $item;
                    }
                }
                return $all;
            }   
            else{
                return false;
            }
        }
    }
    
    public function __destruct(){
        $this->filecsv = null;
        $this->results = null;  
        $this->headers = null;      
    }
    
    
}
?>