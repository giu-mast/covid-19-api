<?php
class CSVReader{
    
    public $filecsv;  
    public $results;   
    public $headers;   
    
    public function __construct($filepath, $delimeter_c=",", $delimeter_r="\n", $enclosure='"', $escape="\\"){  
        if(!file_exists($filepath)){
            throw new Exception("File Error: {$filepath} does not exist."); 
        }
        else if(!is_readable($filepath)){   
            throw new Exception("File Error: {$filepath} does is not readable."); 
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
    
    public function get_results(){
        return $this->results;
    }
    
    public function get_headers(){
        return $this->headers;
    }
    
    public function __destruct(){
        $this->filecsv = null;
        $this->results = null;  
        $this->headers = null;      
    }
    
    
}
?>