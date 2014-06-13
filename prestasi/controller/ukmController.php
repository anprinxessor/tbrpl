<?php
require_once ('../model/ukmModel.php');

class ukmController{
	
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
				$kategori="ukm_nama";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$ukmM = new ukmModel();
		$ukmM->view($keyword, $kategori, $offset, $rows);
	}
	
	private function add(){
		$ukm_nama = $_REQUEST['ukm_nama'];
		$ukmM = new ukmModel();
		$ukmM->add($ukm_nama);
	}
	
	private function update(){
		$ukm_id = $_REQUEST['ukm_id'];
		$ukm_nama = $_REQUEST['ukm_nama'];
		
		$ukmM = new ukmModel();
		$ukmM->update($ukm_id, $ukm_nama);
	}
	
	private function delete(){
		$ukm_id = $_REQUEST['ukm_id'];
		$ukmM = new ukmModel();
		$ukmM->delete($ukm_id);
	}
	
	public function listUkm(){
		$ukmM = new ukmModel();
		$ukmM->listukm();
	}
}
?>