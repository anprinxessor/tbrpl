<?php
require_once ("koneksi.php");

class ukmModel{
	public function __construct(){
		$koneksi = new koneksi();
		$koneksi->connect();
	}
	
	public function view($keyword, $kategori, $offset, $rows) {
		$result = array();
		if (($keyword=="") and ($kategori==""))
		{
			$rs = mysql_query("select count(*) from ukm");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from ukm order by ukm_id
							limit $offset,$rows");
		}
		else
		{
			$kategori = "ukm_nama";
			$rs = mysql_query("select count(*) from ukm where UPPER($kategori) like UPPER('%$keyword%')");	
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from ukm
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
		
	public function add($ukm_nama) {
		$query = "INSERT INTO ukm (ukm_nama) values ('$ukm_nama')";
		$result = mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}

	public function update($ukm_id, $ukm_nama) {
		$query = "UPDATE ukm SET ukm_nama='$ukm_nama' WHERE ukm_id='$ukm_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function delete($ukm_id) {
		$query = "DELETE from ukm where ukm_id='$ukm_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	public function listUkm() {
		$query = "SELECT * from ukm order by ukm_id";
		$result = @mysql_query($query);
		while($data = mysql_fetch_array($result)){
			echo "<option value=".$data['ukm_id'].">".$data['ukm_nama']."</option>";
		}
	}
}
?>