<?php
    
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=utf-8");
    include_once("../../data-layer/CSVReader.php");

    $path_csv = "../../csv/dpc-covid19-ita-regioni.csv";

    $obj_reader = new CSVReader($path_csv);
    

    //echo print_r($obj_reader->results);

    //if($obj_reader->columns_replace(array("date","state","region_code","region_name","province_code","province_name","province_abbreviation","latitude","longitude","total_cases"))){
        //echo "bella\n";
    //}
    //else{
        //echo "dio\n";
    //}
    
    //print_r($obj_reader->headers);

    //echo json_encode($obj_reader->get_all("2020-03-21",true));
    //echo var_dump(in_array(18,array(18)));

    //if(in_array(strtoupper("FG"),array("FG")) == false){
        //echo "dio";
    //}
    //else{
        //echo "cane";
    //}
    echo json_encode($obj_reader->filtered_get_regions("2020-05-03",true,"2020-05232",array("13","15"),array("puglia","calabria")));
    
    //echo var_dump($obj_reader->results[0][$obj_reader->headers[6]]);
?>