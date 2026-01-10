<?php

	//require_once("subdivid.php");
	// Class For Database Connection

	class DBCon{
		// Database Parameters. We can change this parameters for other MES.
		public $host 		= "10.13.144.6";
        public $user       = "user_srspklm";
		public $password 	= "Adm1n@srspklm";
		public $database 	= "electrocure_srspklm";

		
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
