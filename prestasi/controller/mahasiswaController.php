<?php
require_once ('../model/mahasiswaModel.php');

class mahasiswaController{
	
	public function handleRequest($tipe,$fakultas){
		if($tipe=="view"){
			$this->$tipe($fakultas);
		}
		else{
			$this->$tipe();
		}
	}
	
	private function view($fakultas){
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
				$kategori="civitas_akademik_nama";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$mahasiswaM = new mahasiswaModel();
		$mahasiswaM->view($keyword, $kategori, $offset, $rows, $fakultas);
	}
	
	private function add(){
		//$id = $_REQUEST['civitas_akademik_id'];
		$nim = $_REQUEST['nim'];
		$nama = $_REQUEST['civitas_akademik_nama'];
		$tempat_lahir = $_REQUEST['tmpt_lhr'];
		$tanggal_lahir = $_REQUEST['tgl_lhr'];
		$alamat = $_REQUEST['alamat'];
		$telp = $_REQUEST['telp'];
		$hp = $_REQUEST['hp'];
		$email = $_REQUEST['email'];
		$jenis = 0;
		$id_jurusan = $_REQUEST['jurusan_id'];
		$id_ukm = $_REQUEST['ukm_id'];
		
		$mahasiswaM = new mahasiswaModel();
		$mahasiswaM->add($nim,$nama,$tempat_lahir,$tanggal_lahir,$alamat,$telp,$hp,$email,$jenis,$id_jurusan,$id_ukm);
	}
	
	private function update(){
		$id = $_REQUEST['civitas_akademik_id'];
		$nim = $_REQUEST['nim'];
		$nama = $_REQUEST['civitas_akademik_nama'];
		$tempat_lahir = $_REQUEST['tmpt_lhr'];
		$tanggal_lahir = $_REQUEST['tgl_lhr'];
		$alamat = $_REQUEST['alamat'];
		$telp = $_REQUEST['telp'];
		$hp = $_REQUEST['hp'];
		$email = $_REQUEST['email'];
		$id_jurusan = $_REQUEST['jurusan_id'];
		$id_ukm = $_REQUEST['ukm_id'];
		
		$mahasiswaM = new mahasiswaModel();
		$mahasiswaM->update($id,$nim,$nama,$tempat_lahir,$tanggal_lahir,$alamat,$telp,$hp,$email,$id_jurusan,$id_ukm);
	}
	
	private function delete(){
		$id = $_REQUEST['civitas_akademik_id'];
		
		$mahasiswaM = new mahasiswaModel();
		$mahasiswaM->delete($id);
	}
}
?>