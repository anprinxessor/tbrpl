<?php
require_once ("koneksi.php");

class jurusanModel{
	public function __construct(){
		$koneksi = new koneksi();
		$koneksi->connect();
	}
	
	public function view($keyword, $kategori, $offset, $rows) {
		$result = array();
		if (($keyword=="") and ($kategori==""))
		{
			$rs = mysql_query("select count(*) from jurusan, fakultas where fakultas.fakultas_id = jurusan.fakultas_id");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from jurusan, fakultas where fakultas.fakultas_id = jurusan.fakultas_id order by jurusan_id
							limit $offset,$rows");
		}
		else
		{
			$rs = mysql_query("select count(*) from jurusan, fakultas where fakultas.fakultas_id = jurusan.fakultas_id and UPPER($kategori) like UPPER('%$keyword%')");	
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from jurusan, fakultas where fakultas.fakultas_id = jurusan.fakultas_id 
							and $kategori like '%$keyword%' limit $offset,$rows");
		}
			
		$items = array();
		while($row = mysql_fetch_object($rs)){
			array_push($items, $row);
		}
		$result["rows"] = $items;
		$json = json_encode($result);
		echo $json;
		return $json;
	}
		
	public function add($jurusan_nama,$fakultas_id) {
		$query = "INSERT INTO jurusan (jurusan_nama,fakultas_id) values ('$jurusan_nama','$fakultas_id')";
		$result = mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}

	public function update($jurusan_id, $jurusan_nama, $fakultas_id)  {
		$query = "UPDATE jurusan SET jurusan_nama='$jurusan_nama',fakultas_id='$fakultas_id' WHERE jurusan_id='$jurusan_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function delete($jurusan_id) {
		$query = "DELETE from jurusan where jurusan_id='$jurusan_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function listJurusan() {
		$query = "SELECT * from jurusan";
		$result = @mysql_query($query);
		while($data = mysql_fetch_array($result)){
			echo "<option value=".$data['jurusan_id'].">".$data['jurusan_nama']."</option>";
		}
	}
}
?>