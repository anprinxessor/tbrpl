<?php
require_once ("koneksi.php");

class prestasiModel{
	public function __construct(){
		$koneksi = new koneksi();
		$koneksi->connect();
	}
	
	public function view($keyword, $kategori, $offset, $rows) {
		
		$result = array();
		if (($keyword=="") and ($kategori==""))
		{
			$rs = mysql_query("select count(*) from prestasi,tingkat where tingkat.tingkat_id=prestasi.tingkat_id");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from prestasi,tingkat where tingkat.tingkat_id=prestasi.tingkat_id order by tahun DESC
							limit $offset,$rows");
		}
		else
		{
			$rs = mysql_query("select count(*) from prestasi,tingkat where tingkat.tingkat_id=prestasi.tingkat_id and UPPER($kategori) like UPPER('%$keyword%')");	
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from prestasi,tingkat where tingkat.tingkat_id=prestasi.tingkat_id and 
							$kategori like '$keyword%' order by tahun DESC limit $offset,$rows");
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
	
	public function viewDetail($keyword, $kategori, $offset, $rows, $prestasi_id) {
		$result = array();
		if (($keyword=="") and ($kategori=="")){
			$rs = mysql_query("select count(*) from prestasi, prestasi_detail, civitas_akademik 
							where prestasi.prestasi_id = prestasi_detail.prestasi_id and
							civitas_akademik.civitas_akademik_id = prestasi_detail.civitas_akademik_id and prestasi.prestasi_id = '$prestasi_id'");
			$row = mysql_fetch_row($rs);
			$result["total"] = $row[0];
			$rs = mysql_query("select *
							from prestasi, prestasi_detail, civitas_akademik  
							where prestasi.prestasi_id = prestasi_detail.prestasi_id and
							civitas_akademik.civitas_akademik_id = prestasi_detail.civitas_akademik_id and prestasi.prestasi_id = '$prestasi_id'
							limit $offset,$rows");
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
		
	public function add($prestasi_id, $peringkat, $nama_kegiatan,$tempat,$tahun,$tgl_dari,$tgl_sampai,$tingkat_id,$tingkat_ket,$prestasi_jenis,$deskripsi,$status_ukm, $nim, $filename, $uploaddir, $tmpName, $n) {
		$query = "INSERT INTO prestasi (prestasi_id,peringkat,nama_kegiatan,tempat,tahun,tgl_dari,tgl_sampai,tingkat_id,tingkat_ket,prestasi_jenis,deskripsi,status_ukm) values ('$prestasi_id','$peringkat',' $nama_kegiatan','$tempat','$tahun','$tgl_dari','$tgl_sampai','$tingkat_id','$tingkat_ket','$prestasi_jenis','$deskripsi','$status_ukm')";
		$result = mysql_query($query);
		
		$i=0;
		while($i<$n){
			if ($nim[$i]!="" and $filename[$i]!="")
			{
				$bp=$nim[$i];
				$foto=$filename[$i];
				$uploadfile = $uploaddir . $foto;
				$link_foto = '<img src="sertifikat/'.$foto.'" width="150px"/>';
				$query2 = "insert into prestasi_detail values('','$prestasi_id','$bp','$foto','$link_foto')";
				$result2 = mysql_query($query2);
				move_uploaded_file($tmpName[$i], $uploadfile);
			}
			$i++;
		 }
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}

	public function update($prestasi_id, $peringkat, $nama_kegiatan,$tempat,$tahun,$tgl_dari,$tgl_sampai,$tingkat_id,$tingkat_ket,$prestasi_jenis,$deskripsi,$status_ukm) {
		$query = "UPDATE prestasi SET nama_kegiatan='$nama_kegiatan',
								peringkat='$peringkat',
								tempat='$tempat',
								tahun='$tahun',
								tgl_dari='$tgl_dari',
								tgl_sampai='$tgl_sampai',
								tingkat_id='$tingkat_id',
								tingkat_ket='$tingkat_ket',
								prestasi_jenis='$prestasi_jenis',
								deskripsi='$deskripsi',
								status_ukm='$status_ukm'
								 WHERE prestasi_id='$prestasi_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function delete($prestasi_id) {
		$query = "DELETE from prestasi where prestasi_id='$prestasi_id'";
		$result = @mysql_query($query);
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}
	}
	
	public function jumlahNotifikasi(){
		$query = "SELECT prestasi_id FROM prestasi WHERE status_baca='0'";
		$result = mysql_query($query);
		$j = mysql_num_rows($result);
		if ($j>0){
			echo $j;
		}
	}
	
	public function updateStatus(){
		$query = "update prestasi set status_baca='1' where status_baca='0'";
		$result = mysql_query($query);
	}
	
	public function viewNotifikasi(){
		$query = "select peringkat, nama_kegiatan, tempat, tahun, status_ukm, civitas_akademik_nama, nim, fakultas_nama, ukm_nama, status_baca
				from prestasi, fakultas, civitas_akademik, ukm, prestasi_detail, jurusan 
				where 
				prestasi.prestasi_id = prestasi_detail.prestasi_id and
				jurusan.fakultas_id = fakultas.fakultas_id and
				civitas_akademik.civitas_akademik_id = prestasi_detail.civitas_akademik_id and
				jurusan.jurusan_id = civitas_akademik.jurusan_id and
				ukm.ukm_id = civitas_akademik.ukm_id order by status_baca";
		$result = mysql_query($query);
		
		$no=1;
		while($data=mysql_fetch_array($result)){
			if($data['status_baca']=='0'){
				echo"<tr bgcolor='#EDEFF5'>";
			}
			else{
				echo"<tr>";
			}
			echo"
				<td>$no</td>
				<td>".$data['nim']."</td>
				<td>".$data['civitas_akademik_nama']."</td>";
			if($data['status_ukm']=="Ya"){
				echo"<td>".$data['fakultas_nama'].", ".$data['ukm_nama']."</td>";
			}
			else{
				echo"<td>".$data['fakultas_nama']."</td>";
			}
			echo"<td>".$data['peringkat']." ".$data['nama_kegiatan'].", ".$data['tempat'].", ".$data['tahun']."</td>";
			echo"</tr>";
		$no++;
		}
	}
	
	public function laporan($area,$tahun,$prestasi_jenis,$file,$fakultas_id=""){
		$field = "";
		$tabel = "";
		$where = "";
		$judul_area = "";
		$nama_file = "";
		$bidang="";
		
		if($area=="semua"){
			$th = '<th>Jurusan</th><th>Fakultas</th>';
		}
		elseif($area=="ukm"){
			$field = ",ukm_nama, status_ukm";
			$tabel= ", ukm";
			$where = "and ukm.ukm_id = civitas_akademik.ukm_id and status_ukm='Ya'";
			$judul_area = '<center><b>Unit Kegiatan Mahasiswa</center></b><br>';
			$nama_file = "UKM";
			$th = '<th>UKM</th>';
		}
		else{
			$query="select fakultas_nama from fakultas where fakultas_id='$fakultas_id';";
			$result = mysql_query($query);
			$data=mysql_fetch_array($result);
			$where = "and fakultas.fakultas_id='$fakultas_id'";
			$judul_area= '<center><b>Fakultas '.$data['fakultas_nama'].'</b></center><br>';
			$nama_file = "".$data['fakultas_nama'];
			$th = '<th>Jurusan</th>';
		}
		
		if($prestasi_jenis=="semua"){
			$judul_prestasi_jenis = "";
		}
		else{
			$judul_prestasi_jenis = "Bidang ".$prestasi_jenis;
			$bidang="and prestasi_jenis='$prestasi_jenis'";
		}
		
		$query="select prestasi.nama_kegiatan, prestasi.tempat, prestasi.tahun, prestasi.peringkat, prestasi_jenis,
				civitas_akademik.civitas_akademik_nama, nim, jurusan.jurusan_nama, fakultas_nama $field
					FROM prestasi,civitas_akademik, jurusan, prestasi_detail, fakultas $tabel
					WHERE prestasi.prestasi_id = prestasi_detail.prestasi_id and
					jurusan.jurusan_id = civitas_akademik.jurusan_id and 
					civitas_akademik.civitas_akademik_id = prestasi_detail.civitas_akademik_id and tahun='$tahun' and
					fakultas.fakultas_id = jurusan.fakultas_id $where $bidang order by fakultas.fakultas_id, tgl_dari";
		
		
		$result = mysql_query($query);
		
		$judul='
			<center><b>Rekap Prestasi Mahasiswa '.$judul_prestasi_jenis.'</b></center><br>
			'.$judul_area.'
			<center><b>Universitas Andalas</b></center><br>
			<center><b>Tahun '.$tahun.'</b></center><br>
		';
		
		if($file=="excel"){
		$tulis='
		<?php
			ob_start();
			$filename = "Laporan Prestasi '.$nama_file.' '.$tahun.'.xls";
			$s=\'\';
			if($_GET[\'xls\'])
			{
			  header(\'Content-type: application/vnd.ms-excel\');
			  header(\'Content-Disposition: attachment; filename="\'.$filename.\'"\');
			}
			else
			{
			  $s.="<a href=\'?xls=down\'>klik untuk buka dalam bentuk excel</a>";
			}
		?>';
		}
		else{
			$tulis='
			<?php 
			require_once(\'../html2fpdf/html2fpdf.php\');          // agar dapat menggunakan fungsi-fungsi html2pdf
			ob_start();                             // memulai buffer
			error_reporting(1);                     // turn off warning for deprecated functions
			$pdf= new HTML2FPDF();                  // membuat objek HTML2PDF
			$pdf->DisplayPreferences(\'Fullscreen\'); // set preferensi tampilan pdf
			?>
			';
		}
		
		$tulis.='
			<html>
			'.$judul.'';
		
		$no=1;
		
		$tulis.='
		<?php 
		$s.="<table border=\'1\'>
			 <tr>
				<th width=\'5%\'>No</th>
				<th>BP</th>
				<th>Nama</th>
				<th width=\'40%\'>Prestasi</th>'.$th.'
			 </tr>";';
		
		while($data=mysql_fetch_array($result)){
			$tulis.='
			$s.="\n<tr>";
			$s.="\n\t<td>'.$no.'</td>";
			$s.="\n\t<td>'.$data['nim'].'</td>";
			$s.="\n\t<td>'.$data['civitas_akademik_nama'].'</td>";
			$s.="\n\t<td>'.$data['peringkat']." ".$data['nama_kegiatan'].", ".$data['tempat'].", ".$data['tahun'].'</td>";';
			
			if($area=='semua'){
				$tulis.='
				$s.="\n\t<td>'.$data['jurusan_nama'].'</td>";
				$s.="\n\t<td>'.$data['fakultas_nama'].'</td>";';
			}
			elseif($area=="ukm"){
				$tulis.='
				$s.="\n\t<td>'.$data['ukm_nama'].'</td>";';
			}
			else{
				$tulis.='$s.="\n\t<td>'.$data['jurusan_nama'].'</td>";';
			}
			
			$tulis.='$s.="\n</tr>";';
			$no++;
		}
		
		$tulis.='	
			$s.="</table>";
			print $s;
		?>	
			</html> ';
		
		if($file=="excel"){
				$tulis.='
			<?php
				ob_end_flush();
			?>';
			$fp=fopen ("../download/xls.php","w");
			fputs ($fp, $tulis);
			fclose ($fp);
			echo "<script>window.open('download/xls.php?xls=down', '_self')</script>";
		}
		else{
			$tulis.='
				<?php
				$html=ob_get_contents();                // mengambil data dengan format html, dan disimpan di variabel
				ob_end_clean();                         // mengakhiri buffer dan tidak menampilkan data dalam format html
				$pdf->addPage();                        // menambah halaman di file pdf
				$pdf->WriteHTML($html);                 // menuliskan data dengan format html ke file pdf
				$pdf->Output(\'Laporan Prestasi '.$nama_file.' '.$tahun.'.pdf\',\'D\');         // mengeluarkan file pdf dengan nama tes001.pdf dalam bentuk file yang bisa di download
				?>
			';
			$fp=fopen ("../download/pdf.php","w");
			fputs ($fp, $tulis);
			fclose ($fp);
			echo "<script>window.open('download/pdf.php', '_self')</script>";
		}
	}
}
?>