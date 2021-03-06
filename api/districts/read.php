<?php

    if (!defined('E_LOG_PATH')) define("E_LOG_PATH",$_SERVER["DOCUMENT_ROOT"]."/log_errors.txt");;
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=utf-8");
    include_once($_SERVER["DOCUMENT_ROOT"]."/data-layer/CSVReader.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/data-layer/JSONAdapter.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/models/district.php");

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
        $obj_district = new District();
        $start_date; 
        $end_date;
        $single;
        $district_code;
        $district_name;
        
        if(isset($_GET["all"]) || isset($_GET["start_date"]) || isset($_GET["end_date"]) || isset($_GET["single"]) || isset($_GET["district_code"]) || isset($_GET["district_name"])){
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
                if($obj_district->get_all($start_date,$single,$end_date) != false){
                    http_response_code(200);
                    echo $obj_district->get_all($start_date,$single,$end_date);
                }
                else{
                    http_response_code(422);
                    echo $obj_district->get_error_json(array("Status Code"=>"422","Client Error"=>"Server unable to process the request, some values are not valid"));
                    $current_date = new DateTime();
                    $fileError = fopen(E_LOG_PATH,"a");
                    fwrite($fileError,"[endpoint->districts] [date->".$current_date->format('Y-m-d H:i:s')."] [client_IP->".getUserIpAddr()."] [Client_Error->Server unable to process the request, some values are not valid] [Status_Code->422]");
                    fclose($fileError);
                }
            }
            else{
                if(isset($_GET["start_date"]) && gettype($_GET["start_date"]) == "string"){$start_date = $_GET["start_date"];}
                else{$start_date = false;}
                if(isset($_GET["end_date"]) && gettype($_GET["end_date"]) == "string"){$end_date = $_GET["end_date"];}
                else{$end_date = false;}
                if(isset($_GET["district_code"]) && gettype($_GET["district_code"]) == "string"){$district_code = explode(",",$_GET["district_code"]);}
                else{$district_code = false;}
                if(isset($_GET["district_name"]) && gettype($_GET["district_name"]) == "string"){$district_name = explode(",",$_GET["district_name"]);}
                else{$district_name = false;}
                if(isset($_GET["single"])){
                    $single = settype($_GET["single"], 'boolean');
                    if(gettype($single) != "boolean"){
                        $single = false;
                    }
                }
                else{$single = false;}
                if($obj_district->filtered_get_districts($start_date,$single,$end_date,$district_code,$district_name) != false){
                    http_response_code(200);
                    echo $obj_district->filtered_get_districts($start_date,$single,$end_date,$district_code,$district_name);
                }
                else{
                    http_response_code(422);
                    echo $obj_district->get_error_json(array("Status Code"=>"422","Client Error"=>"Server unable to process the request, some values are not valid"));
                    $current_date = new DateTime();
                    $fileError = fopen(E_LOG_PATH,"a");
                    fwrite($fileError,"[endpoint->districts] [date->".$current_date->format('Y-m-d H:i:s')."] [client_IP->".getUserIpAddr()."] [Client_Error->Server unable to process the request, some values are not valid] [Status_Code->422]");
                    fclose($fileError);
                }
            }
        }
        else{
            http_response_code(400);
            echo $obj_district->get_error_json(array("Status Code"=>"400","Client Error"=>"No valid value passed in the query string"));
            $current_date = new DateTime();
            $fileError = fopen(E_LOG_PATH,"a");
            fwrite($fileError,"[date->".$current_date->format('Y-m-d H:i:s')."] [client_IP->".getUserIpAddr()."] [Client_Error->No valid value passed in the query string] [Status_Code->400]");
            fclose($fileError);
        }
    }
    catch(Exception $e){
        http_response_code(500);
        echo $obj_district->get_error_json(array("Status Code"=>"500","Server Error:"=>"{$e}"));
        $current_date = new DateTime();
        $fileError = fopen(E_LOG_PATH,"a");
        fwrite($fileError,"[endpoint->districts] [date->".$current_date->format('Y-m-d H:i:s')."] [Server_Error->{$e}] [Status_Code->500]");
        fclose($fileError);
    }

?>