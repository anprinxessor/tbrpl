<?php
require_once ('../model/jurusanModel.php');

class jurusanController{
	
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
				$kategori="jurusan_nama";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$jurusanM = new jurusanModel();
		$jurusanM->view($keyword, $kategori, $offset, $rows);
	}
	
	private function add(){
		$jurusan_nama = $_REQUEST['jurusan_nama'];
		$fakultas_id = $_REQUEST['fakultas_id'];
		$jurusanM = new jurusanModel();
		$jurusanM->add($jurusan_nama, $fakultas_id);
	}
	
	private function update(){
		$jurusan_id = $_REQUEST['jurusan_id'];
		$jurusan_nama = $_REQUEST['jurusan_nama'];
		$fakultas_id = $_REQUEST['fakultas_id'];
		$jurusanM = new jurusanModel();
		$jurusanM->update($jurusan_id, $jurusan_nama, $fakultas_id);
	}
	
	private function delete(){
		$jurusan_id = $_REQUEST['jurusan_id'];
		$jurusanM = new jurusanModel();
		$jurusanM->delete($jurusan_id);
	}
	
	public function listJurusan(){
		$jurusanM = new jurusanModel();
		$jurusanM->listJurusan();
	}
}
?>