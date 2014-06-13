<?php
require_once ('../model/fakultasModel.php');

class fakultasController{
	
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
				$kategori="fakultas_nama";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$fakultasM = new fakultasModel();
		$fakultasM->view($keyword, $kategori, $offset, $rows);
	}
	
	private function add(){
		$fakultas_kode = $_REQUEST['fakultas_kode'];
		$fakultas_nama = $_REQUEST['fakultas_nama'];
		$fakultasM = new fakultasModel();
		$fakultasM->add($fakultas_kode, $fakultas_nama);
	}
	
	private function update(){
		$fakultas_id = $_REQUEST['fakultas_id'];
		$fakultas_nama = $_REQUEST['fakultas_nama'];
		$fakultas_kode = $_REQUEST['fakultas_kode'];
		$fakultasM = new fakultasModel();
		$fakultasM->update($fakultas_id, $fakultas_nama, $fakultas_kode);
	}
	
	private function delete(){
		$fakultas_id = $_REQUEST['fakultas_id'];
		$fakultasM = new fakultasModel();
		$fakultasM->delete($fakultas_id);
	}
	
	public function listFakultas(){
		$fakultasM = new fakultasModel();
		$fakultasM->listFakultas();
	}
}
?>