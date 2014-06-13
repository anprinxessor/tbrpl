<?php
	session_start();
	$fakultas = $_SESSION['fakultas_id'];
	//mengecek tipe (CRUD) dan tabel
	if(isset($_GET['tipe']) && isset($_GET['tabel'])){
		$tipe = $_GET['tipe'];
		$tabel = $_GET['tabel'];
		
		switch ($tabel) {
		case "fakultas":
			include ('fakultasController.php');
			$fakultasC = new fakultasController();
			$fakultasC->handleRequest($tipe);
			break;
		case "jurusan":
			include ('jurusanController.php');
			$jurusanC = new jurusanController();
			$jurusanC->handleRequest($tipe);
			break;
		case "tingkat":
			include ('tingkatController.php');
			$tingkatC = new tingkatController();
			$tingkatC->handleRequest($tipe);
			break;
		case "ukm":
			include ('ukmController.php');
			$ukmC = new ukmController();
			$ukmC->handleRequest($tipe);
			break;	
		case "prestasi":
			include ('prestasiController.php');
			$prestasiC = new prestasiController();
			$prestasiC->handleRequest($tipe,$fakultas);
			break;
		case "user":
			include ('userController.php');
			$userC = new userController();
			$userC->handleRequest($tipe);
			break;
		case "mahasiswa":
			include ('mahasiswaController.php');
			$mahasiswaC = new mahasiswaController();
			$mahasiswaC->handleRequest($tipe,$fakultas);
			break;
		
		  default:
			//echo "Your favorite color is neither red, blue, or green!";
		}
	}
	else{
		//belum ada statement
	}
?>