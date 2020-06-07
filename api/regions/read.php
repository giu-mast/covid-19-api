<?php

    if (!defined('E_LOG_PATH')) define("E_LOG_PATH",$_SERVER["DOCUMENT_ROOT"]."/log_errors.txt");;
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=utf-8");
    include_once($_SERVER["DOCUMENT_ROOT"]."/data-layer/CSVReader.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/data-layer/JSONAdapter.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/models/region.php");

    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }   
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }   
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    try{
        $obj_region = new Region();
        $start_date; 
        $end_date;
        $single;
        $region_code;
        $region_name;
        
        if(isset($_GET["all"]) || isset($_GET["start_date"]) || isset($_GET["end_date"]) || isset($_GET["single"]) || isset($_GET["region_code"]) || isset($_GET["region_name"])){
            if(isset($_GET["all"]) && $_GET["all"] == true){
                if(isset($_GET["start_date"]) && gettype($_GET["start_date"]) == "string"){$start_date = $_GET["start_date"];}
                else{$start_date = false;}
                if(isset($_GET["end_date"]) && gettype($_GET["end_date"]) == "string"){$end_date = $_GET["end_date"];}
                else{$end_date = false;}
                if(isset($_GET["single"])){
                    $single = settype($_GET["single"], 'boolean');
                    if(gettype($single) != "boolean"){
                        $single = false;
                    }
                }
                else{
                    $single = false;
                }
                if($obj_region->get_all($start_date,$single,$end_date) != false){
                    http_response_code(200);
                    echo $obj_region->get_all($start_date,$single,$end_date);
                }
                else{
                    http_response_code(422);
                    echo $obj_region->get_error_json(array("Status Code"=>"422","Client Error"=>"Server unable to process the request, some values are not valid"));
                    $current_date = new DateTime();
                    $fileError = fopen(E_LOG_PATH,"a");
                    fwrite(
                        $fileError,
                        "[endpoint->regions] [date->".$current_date->format('Y-m-d H:i:s')."] [client_IP->".getUserIpAddr()."]\n\r[Client_Error->Server unable to process the request, some values are not valid] [Status_Code->422]\n\r\n\r"
                    );
                    fclose($fileError);
                }
            }
            else{
                if(isset($_GET["start_date"]) && gettype($_GET["start_date"]) == "string"){$start_date = $_GET["start_date"];}
                else{$start_date = false;}
                if(isset($_GET["end_date"]) && gettype($_GET["end_date"]) == "string"){$end_date = $_GET["end_date"];}
                else{$end_date = false;}
                if(isset($_GET["region_code"]) && gettype($_GET["region_code"]) == "string"){$region_code = explode(",",$_GET["region_code"]);}
                else{$region_code = false;}
                if(isset($_GET["region_name"]) && gettype($_GET["region_name"]) == "string"){$region_name = explode(",",$_GET["region_name"]);}
                else{$region_name = false;}
                if(isset($_GET["single"])){
                    $single = settype($_GET["single"], 'boolean');
                    if(gettype($single) != "boolean"){
                        $single = false;
                    }
                }
                else{$single = false;}
                if($obj_region->filtered_get_regions($start_date,$single,$end_date,$region_code,$region_name) != false){
                    http_response_code(200);
                    echo $obj_region->filtered_get_regions($start_date,$single,$end_date,$region_code,$region_name);
                }
                else{
                    http_response_code(422);
                    echo $obj_region->get_error_json(array("Status Code"=>"422","Client Error"=>"Server unable to process the request, some values are not valid"));
                    $current_date = new DateTime();
                    $fileError = fopen(E_LOG_PATH,"a");
                    fwrite(
                        $fileError,
                        "[endpoint->regions] [date->".$current_date->format('Y-m-d H:i:s')."] [client_IP->".getUserIpAddr()."]\n\r[Client_Error->Server unable to process the request, some values are not valid] [Status_Code->422]\n\r\n\r"
                    );
                    fclose($fileError);
                }
            }
        }
        else{
            http_response_code(400);
            echo $obj_region->get_error_json(array("Status Code"=>"400","Client Error"=>"No valid value passed in the query string"));
        }
    }
    catch(Exception $e){
        http_response_code(500);
        echo $obj_region->get_error_json(array("Status Code"=>"500","Server Error:"=>"{$e}"));
        $current_date = new DateTime();
        $fileError = fopen(E_LOG_PATH,"a");
        fwrite($fileError,"[endpoint->regions] [date->".$current_date->format('Y-m-d H:i:s')."] [Server_Error->{$e}] [Status_Code->500]");
        fclose($fileError);
    }

?>