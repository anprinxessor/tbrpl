<?php
require_once ("koneksi.php");

class fakultasModel{
	public function __construct(){
		$koneksi = new koneksi();
		$koneksi->connect();
	}
	
	public function view($keyword, $kategori, $offset, $rows) {
		$result = array();
		if (($keyword=="") and ($kategori==""))
		{
			$rs = mysql_query("select count(*) from fakultas");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from fakultas order by fakultas_kode
							limit $offset,$rows");
		}
		else
		{
			$kategori="fakultas_nama";
			$rs = mysql_query("select count(*) from fakultas where UPPER($kategori) like UPPER('%$keyword%')");	
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from fakultas 
							where $kategori like '%$keyword%' limit $offset,$rows");
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
		
	public function add($fakultas_kode, $fakultas_nama) {
		$query = "INSERT INTO fakultas (fakultas_kode, fakultas_nama) values ('$fakultas_kode','$fakultas_nama')";
		$result = mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}

	public function update($fakultas_id, $fakultas_nama, $fakultas_kode) {
		$query = "UPDATE fakultas SET fakultas_nama='$fakultas_nama', fakultas_kode='$fakultas_kode' WHERE fakultas_id='$fakultas_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function delete($fakultas_id) {
		$query = "DELETE from fakultas where fakultas_id='$fakultas_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function listFakultas() {
		$query = "SELECT * from fakultas order by fakultas_kode";
		$result = @mysql_query($query);
		while($data = mysql_fetch_array($result)){
			echo "<option id=".$data['fakultas_id']." value=".$data['fakultas_id'].">".$data['fakultas_nama']."</option>";
		}
	}
}
?>