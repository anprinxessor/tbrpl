<?php
require_once ('../model/userModel.php');

class userController{
	
	public function handleRequest($tipe){
		$this->$tipe();
	}
	
	private function view(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$result = array();
		if(!isset($_POST['keyword']) and !isset($_POST['kategori'])){
			$keyword = "";
			$kategori = "";
		}
		else{
			$keyword = $_POST['keyword'];
			if(!isset($_POST['kategori'])){
				$kategori="username";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$userM = new userModel();
		$userM->view($keyword, $kategori, $offset, $rows);
	}
	
	private function add(){
		$username = $_REQUEST['username'];
		$pass = sha1($_REQUEST['pass']);
		$ket = $_REQUEST['ket'];
		$user_jenis = $_REQUEST['user_jenis'];
		$fakultas_id = $_REQUEST['fakultas_id'];
		$userM = new userModel();
		$userM->add($username,$pass,$ket,$user_jenis,$fakultas_id);
	}
	
	private function update(){
		$user_id = $_REQUEST['user_id'];
		$username = $_REQUEST['username'];
		$pass = sha1($_REQUEST['pass']);
		$ket = $_REQUEST['ket'];
		$user_jenis = $_REQUEST['user_jenis'];
		$fakultas_id = $_REQUEST['fakultas_id'];
		$userM = new userModel();
		$userM->update($user_id,$username,$pass,$ket,$user_jenis,$fakultas_id);
	}
	
	private function delete(){
		$user_id = $_REQUEST['user_id'];
		$userM = new userModel();
		$userM->delete($user_id);
	}
}
?>