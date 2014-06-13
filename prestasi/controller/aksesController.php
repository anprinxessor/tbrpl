<?php
	require_once ("model/userModel.php");
	
	class aksesController{
		
		//mengecek sudah login atau belum
		public function cekSesi(){
			if(isset($_SESSION['login'])){ //session login ada
				require_once("view/home.php");
			}
			else{ // session login tak ada
				require_once("view/loginForm.php");
				$this->login();
			}	
		}
		
		//submit form login
		private function login(){
			if(isset($_POST['submit'])){				
				$username = $_POST["username"];
				$password = sha1($_POST["password"]);
				
				$user = new userModel(); //membuat objek user dari kelas user di userModel.php
				$sukses = $user->getSesi($username,$password); //memanggil method getSesi
				if($sukses==true){
					echo"<script languange='javasript'>document.location='index.php'</script>";
				}
				else{
					echo"<script languange='javasript'>alert('Username atau password salah');</script>";
				}
			}
			else{
				// belum ada statement
			}
		}
		
		public function logout(){
			session_destroy();
			echo"<script languange='javasript'>document.location='index.php'</script>";
		}
		
		public function menu($jenis){
			switch ($jenis) {
			case "Admin Universitas":
				echo'
				<li id="notifikasi1" class=""><a href="#" onclick="notifikasi()"><i class="icon-inbox"></i> Notifikasi Prestasi <b><span id="notifikasi"></span></b><i class="icon-chevron-right"></i></a></li>
				<li id="prestasi" class=""><a href="#" onclick="prestasi()"><i class="icon-star"></i> Pengelolaan Data Prestasi<i class="icon-chevron-right"></i></a></li>
				<li id="mahasiswa" class=""><a href="#" onclick="mahasiswa()"><i class="icon-user"></i> Pengelolaan Data Mahasiswa<i class="icon-chevron-right"></i></a></li>
				<li id="fakultas" class=""><a href="#" onclick="fakultas();"><i class="icon-th-large"></i> Pengelolaan Data Fakultas <i class="icon-chevron-right"></i></a></li>
				<li id="jurusan" class=""><a href="#" onclick="jurusan()"><i class="icon-list"></i> Pengelolaan Data Jurusan<i class="icon-chevron-right"></i></a></li>
				<li id="ukm" class=""><a href="#" onclick="ukm()"><i class="icon-th"></i> Pengelolaan Data UKM<i class="icon-chevron-right"></i></a></li>
				<li id="tingkat" class=""><a href="#" onclick="tingkat()"><i class="icon-signal"></i> Pengelolaan Data Tingkat<i class="icon-chevron-right"></i></a></li>
				<li id="user" class=""><a href="#" onclick="user()"><i class="icon-user"></i> Pengelolaan Data User<i class="icon-chevron-right"></i></a></li>
				<li id="laporan" class=""><a href="#" onclick="laporan()"><i class="icon-file"></i> Laporan Prestasi<i class="icon-chevron-right"></i></a></li>';
				break;
			case "Admin Fakultas":
				echo'
				<li><a href="#" onclick="prestasi()"><i class="icon-star"></i> Pengelolaan Data Prestasi<i class="icon-chevron-right"></i></a></li>
				<li><a href="#" onclick="mahasiswa()"><i class="icon-user"></i> Pengelolaan Data Mahasiswa<i class="icon-chevron-right"></i></a></li>
				<li><a href="#" onclick="laporan()"><i class="icon-file"></i> Laporan Prestasi<i class="icon-chevron-right"></i></a></li>';
				break;
			case "Wakil Rektor 3":
				echo'
				<li><a href="#" onclick="prestasi()"><i class="icon-star"></i> Pencarian Data Prestasi<i class="icon-chevron-right"></i></a></li>
				<li><a href="#" onclick="laporan()"><i class="icon-file"></i> Laporan Prestasi<i class="icon-chevron-right"></i></a></li>';
				break;
			  default:
				//echo "Your favorite color is neither red, blue, or green!";
			}
		}
	}

?>