<?php
	require_once ("koneksi.php");
	
	class userModel{
		public function __construct(){
			$koneksi = new koneksi();
			$koneksi->connect();
		}
		
		public function getSesi($username,$password){
			$query = "select username, pass, ket, user_jenis, fakultas.fakultas_id as fakultas_id  from user, fakultas where username='$username' and pass='$password' and fakultas.fakultas_id = user.fakultas_id";
			$result = mysql_query($query);
			$data = mysql_fetch_array($result);
			$numrows = mysql_num_rows($result);
			
			if ($numrows == 1) {
				$_SESSION['login'] = true;
				$_SESSION['ket'] = $data['ket'];
				$_SESSION['user_jenis'] = $data['user_jenis'];
				$_SESSION['fakultas_id'] = $data['fakultas_id'];
				return true;
			}
			else{
				return false;
			}
		}
		
		public function view($keyword, $kategori, $offset, $rows) {
			$result = array();
			if (($keyword=="") and ($kategori==""))
			{
				$rs = mysql_query("select count(*) from user, fakultas where user.fakultas_id = fakultas.fakultas_id");
				$row = mysql_fetch_row($rs);
				$result["total"] = $row[0];
			
				$rs = mysql_query("select *
							from user, fakultas where user.fakultas_id = fakultas.fakultas_id
							limit $offset,$rows");
			}
			else
			{
				$rs = mysql_query("select count(*) from user, fakultas where user.fakultas_id = fakultas.fakultas_id and UPPER($kategori) like UPPER('%$keyword%')");	
				$row = mysql_fetch_row($rs);
				$result["total"] = $row[0];
			
				$rs = mysql_query("select *
							from user , fakultas where user.fakultas_id = fakultas.fakultas_id and
							$kategori like '%$keyword%' limit $offset,$rows");
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
		
		public function add($username,$pass,$ket,$user_jenis,$fakultas_id) {
			$query = "insert into user (username,pass,ket,user_jenis,fakultas_id) values ('$username','$pass','$ket','$user_jenis','$fakultas_id')";
			$result = mysql_query($query);
			if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'Some errors occured.'));
			}
		}

		public function update($user_id,$username,$pass,$ket,$user_jenis,$fakultas_id) {
			$query = "update user set username='$username',pass='$pass',ket='$ket',user_jenis='$user_jenis',fakultas_id='$fakultas_id' where user_id='$user_id'";
			$result = @mysql_query($query);
			if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'Some errors occured.'));
			}
		}
	
		public function delete($user_id) {
			$query = "DELETE from user where user_id='$user_id'";
			$result = @mysql_query($query);
			if ($result){
				echo json_encode(array('success'=>true));
			} else {
				echo json_encode(array('msg'=>'Some errors occured.'));
			}
		}	
	}
?>