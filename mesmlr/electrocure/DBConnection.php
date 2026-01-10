<?php

	//require_once("subdivid.php");
	// Class For Database Connection

	class DBCon{
		

		public $host 		= "localhost";
        public $user       = "root";
		public $password 	= "";
		public $database 	= "electrocure";
		
		public $db;
		/* This function is used for creating Connection with Database. if connection is made successfully then it will return TRUE otherwise it will return FALSE*/
		public function Open(){
			$this->db = new mysqli($this->host , $this->user , $this->password , $this->database);
				if(!$this->db){
					return false;
					
				}else{
					return true;
					
				}
		}
	}

?>
