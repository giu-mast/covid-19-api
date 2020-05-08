<?php
	/*
		data,denominaz,deceduti
		20/04,puglia,100
		21/04,puglia,150
		[
			{
				"data": "20/04",
				"denominazione": "puglia",
				"deceduti": 100
			},
			{
				"data": "21/04",
				"denominazione": "puglia",
				"deceduti": 150
			}
		]
	*/
	class JSONAdapter{

		private $json_obj;

		public function __construct($array){
			if(gettype($prova) != "array"){
				throw new Exception("Error:{$prova} -> the variable is not an array.");	
			}else{
				$this->json_obj = json_encode($array);
			}
			
		}

		public function get_json(){
			return $this->json_obj;
		}

		public function __destruct(){
			$this->json_obj = null;
		}

	}
?>
