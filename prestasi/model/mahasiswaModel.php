<?php
require_once ("koneksi.php");

class mahasiswaModel{
	public function __construct(){
		$koneksi = new koneksi();
		$koneksi->connect();
	}
	
	public function view($keyword, $kategori, $offset, $rows, $fakultas) {
		if($fakultas=='1'){
			$query="";
		}
		else{
			$query="and jurusan.fakultas_id = '$fakultas'";
		}
		$result = array();
		if (($keyword=="") and ($kategori==""))
		{
			$rs = mysql_query("select count(*) from civitas_akademik, jurusan, ukm, fakultas 
								WHERE civitas_akademik_jenis = 0 and 
								jurusan.jurusan_id = civitas_akademik.jurusan_id and
								ukm.ukm_id = civitas_akademik.ukm_id and
								fakultas.fakultas_id = jurusan.fakultas_id $query");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from civitas_akademik, jurusan, ukm, fakultas
								WHERE civitas_akademik_jenis = 0 and 
								jurusan.jurusan_id = civitas_akademik.jurusan_id and
								ukm.ukm_id = civitas_akademik.ukm_id and
								fakultas.fakultas_id = jurusan.fakultas_id $query
								order by civitas_akademik_id
							limit $offset,$rows");
		}
		else
		{
			$rs = mysql_query("select count(*) from civitas_akademik, jurusan, ukm, fakultas 
								WHERE civitas_akademik_jenis = 0 and 
								jurusan.jurusan_id = civitas_akademik.jurusan_id and
								ukm.ukm_id = civitas_akademik.ukm_id and
								fakultas.fakultas_id = jurusan.fakultas_id and UPPER($kategori) like UPPER('%$keyword%') $query");	
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from civitas_akademik, jurusan, ukm, fakultas
								WHERE civitas_akademik_jenis = 0 and 
								jurusan.jurusan_id = civitas_akademik.jurusan_id and
								ukm.ukm_id = civitas_akademik.ukm_id and
								fakultas.fakultas_id = jurusan.fakultas_id and $kategori like '%$keyword%' $query limit $offset,$rows");
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
		
	public function add($nim,$nama,$tempat_lahir,$tanggal_lahir,$alamat,$telp,$hp,$email,$jenis,$id_jurusan,$id_ukm) {
		$query = "INSERT INTO civitas_akademik (civitas_akademik_id, nim, civitas_akademik_nama, tmpt_lhr, tgl_lhr, alamat, telp, hp, email, civitas_akademik_jenis, jurusan_id, ukm_id) VALUES ('$nim','$nim', '$nama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$telp', '$hp', '$email', '0', '$id_jurusan', '$id_ukm')";
		$result = mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'.$query));
		}
	}

	public function update($id,$nim,$nama,$tempat_lahir,$tanggal_lahir,$alamat,$telp,$hp,$email,$id_jurusan,$id_ukm) {
		$query = "UPDATE civitas_akademik SET nim='$nim', civitas_akademik_nama='$nama', tmpt_lhr='$tempat_lahir', tgl_lhr='$tanggal_lahir', alamat='$alamat', telp='$telp',hp='$hp', email='$email', jurusan_id='$id_jurusan',ukm_id='$id_ukm' WHERE civitas_akademik_id='$id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
			//$json = json_encode($result);
			//echo $json;
		}
	}
	
	public function delete($id) {
		$query = "DELETE from civitas_akademik WHERE civitas_akademik_id='$id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
}
?>