<?php
	class koneksi{
		private $host="localhost";
		private $user="root";
		private $pass="";
		private $db="prestasi_apps";
		
		function connect()
		{
			mysql_connect($this->host,$this->user,$this->pass);
			mysql_select_db($this->db) or die ("Database tidak ada");
		}
	} 
?>
