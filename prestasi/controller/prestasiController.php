<?php
require_once ('../model/prestasiModel.php');

class prestasiController{
	
	public function handleRequest($tipe,$fakultas=0){
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
				$kategori="prestasi_id";
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$prestasiM = new prestasiModel();
		$prestasiM->view($keyword, $kategori, $offset, $rows);
	}
	
	private function viewDetail(){
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
			}
			else{
				$kategori = $_POST['kategori'];
			}
		}
		$prestasi_id = $_REQUEST['prestasi_id'];
		$prestasiM = new prestasiModel();
		$prestasiM->viewDetail($keyword, $kategori, $offset, $rows, $prestasi_id);
	}
	
	private function add(){
			$prestasi_id = $_REQUEST['prestasi_id'];
			$nama_kegiatan = $_REQUEST['nama_kegiatan'];
			$peringkat = $_REQUEST['peringkat'];
			$tempat = $_REQUEST['tempat'];
			$tahun = $_REQUEST['tahun'];
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_sampai = $_REQUEST['tgl_sampai'];
			$tingkat_id = $_REQUEST['tingkat_id'];
			$tingkat_ket = $_REQUEST['tingkat_ket'];
			$prestasi_jenis = $_REQUEST['prestasi_jenis'];
			$deskripsi = $_REQUEST['deskripsi'];
			$status_ukm = $_REQUEST['status_ukm'];
			$uploaddir = '../sertifikat/';
			$tmpName = $_FILES['foto']['tmp_name'];
			$n = count($_REQUEST['data']);
			$nim = $_REQUEST['data'];
			$filename = $_FILES['foto']['name'];
		$prestasiM = new prestasiModel();
		$prestasiM->add($prestasi_id, $peringkat, $nama_kegiatan,$tempat,$tahun,$tgl_dari,$tgl_sampai,$tingkat_id,$tingkat_ket,$prestasi_jenis,$deskripsi,$status_ukm, $nim, $filename, $uploaddir, $tmpName, $n);
	}
	
	private function update(){
			$prestasi_id = $_REQUEST['prestasi_id'];
			$peringkat = $_REQUEST['peringkat'];
			$nama_kegiatan = $_REQUEST['nama_kegiatan'];
			$tempat = $_REQUEST['tempat'];
			$tahun = $_REQUEST['tahun'];
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_sampai = $_REQUEST['tgl_sampai'];
			$tingkat_id = $_REQUEST['tingkat_id'];
			$tingkat_ket = $_REQUEST['tingkat_ket'];
			$prestasi_jenis = $_REQUEST['prestasi_jenis'];
			$deskripsi = $_REQUEST['deskripsi'];
			$status_ukm = $_REQUEST['status_ukm'];
			$prestasiM = new prestasiModel();
			$prestasiM->update($prestasi_id, $peringkat, $nama_kegiatan,$tempat,$tahun,$tgl_dari,$tgl_sampai,$tingkat_id,$tingkat_ket,$prestasi_jenis,$deskripsi,$status_ukm);
	}
	
	private function delete(){
		$prestasi_id = $_REQUEST['prestasi_id'];
		$prestasiM = new prestasiModel();
		$prestasiM->delete($prestasi_id);
	}
	
	private function jumlahNotifikasi(){
		$prestasiM = new prestasiModel();
		$prestasiM->jumlahNotifikasi();
	}
	
	private function updateStatus(){
		$prestasiM = new prestasiModel();
		$prestasiM->updateStatus();
		}
	
	private function viewNotifikasi(){
		$prestasiM = new prestasiModel();
		$prestasiM->viewNotifikasi();
		}
	
	private function laporan(){
		$area = $_REQUEST['area'];
		$tahun = $_REQUEST['tahun'];
		$prestasi_jenis = $_REQUEST['prestasi_jenis'];
		$file = $_REQUEST['file'];
		$fakultas_id = $_REQUEST['fakultas_id'];
		$prestasiM = new prestasiModel();
		$prestasiM->laporan($area,$tahun,$prestasi_jenis,$file,$fakultas_id);
	}
	
	public function toolbar($jenis){
			if($jenis=="Admin Universitas" || $jenis=="Admin Fakultas"){
				echo'
				<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newPrestasi()">Tambah</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPrestasi()">Ubah</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="deletePrestasi()">Hapus</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchPrestasi()">Cari</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="refreshPrestasi()">Refresh</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="detailPrestasi()">Detail Prestasi</a>';
			}
			else{
				echo'
				<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchPrestasi()">Cari</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="refreshPrestasi()">Refresh</a>';
			}
		}
}
?>