<?php
require_once ('../model/tingkatModel.php');

class tingkatController{
	
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
				$kategori="tingkat_nama";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$tingkatM = new tingkatModel();
		$tingkatM->view($keyword, $kategori, $offset, $rows);
	}
	
	private function add(){
		$tingkat_nama = $_REQUEST['tingkat_nama'];
		$tingkatM = new tingkatModel();
		$tingkatM->add($tingkat_nama);
	}
	
	private function update(){
		$tingkat_id = $_REQUEST['tingkat_id'];
		$tingkat_nama = $_REQUEST['tingkat_nama'];
		
		$tingkatM = new tingkatModel();
		$tingkatM->update($tingkat_id, $tingkat_nama);
	}
	
	private function delete(){
		$tingkat_id = $_REQUEST['tingkat_id'];
		$tingkatM = new tingkatModel();
		$tingkatM->delete($tingkat_id);
	}
	public function listTingkat(){
		$tingkatM = new tingkatModel();
		$tingkatM->listtingkat();
	}
}
?>