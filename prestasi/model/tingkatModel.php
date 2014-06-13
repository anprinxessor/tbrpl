<?php
require_once ("koneksi.php");

class tingkatModel{
	public function __construct(){
		$koneksi = new koneksi();
		$koneksi->connect();
	}
	
	public function view($keyword, $kategori, $offset, $rows) {
		$result = array();
		if (($keyword=="") and ($kategori==""))
		{
			$rs = mysql_query("select count(*) from tingkat");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from tingkat order by tingkat_id
							limit $offset,$rows");
		}
		else
		{
			$kategori ="tingkat_nama";
			$rs = mysql_query("select count(*) from tingkat where UPPER($kategori) like UPPER('%$keyword%')");	
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from tingkat
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
		
	public function add($tingkat_nama) {
		$query = "INSERT INTO tingkat (tingkat_nama) values ('$tingkat_nama')";
		$result = mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}

	public function update($tingkat_id, $tingkat_nama) {
		$query = "UPDATE tingkat SET tingkat_nama='$tingkat_nama' WHERE tingkat_id='$tingkat_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function delete($tingkat_id) {
		$query = "DELETE from tingkat where tingkat_id='$tingkat_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function listTingkat() {
		$query = "SELECT * from tingkat order by tingkat_id";
		$result = @mysql_query($query);
		while($data = mysql_fetch_array($result)){
			echo "<option value=".$data['tingkat_id'].">".$data['tingkat_nama']."</option>";
		}
	}
}
?>