
<?php
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


