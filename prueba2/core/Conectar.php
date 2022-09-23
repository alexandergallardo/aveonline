<?php
	class Conectar{
		private $driver;
		private $host, $user, $pass, $database, $charset;
	   
		public function __construct() {
			$db = require_once 'config/database.php';
			
			$this->driver   = $db["driver"];
			$this->host     = $db["host"];
			$this->user     = $db["user"];
			$this->pass     = $db["pass"];
			$this->database = $db["database"];
			$this->charset  = $db["charset"];
		}
		 
		public function conexion(){
			 
			if($this->driver == "mysql" || $this->driver == null){
				$con = new mysqli($this->host, $this->user, $this->pass, $this->database);
				$con->query("SET NAMES '".$this->charset."'");
			}
			 
			return isset($con) ? $con : false;
		}
	}
?>
