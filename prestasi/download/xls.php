
		<?php
			ob_start();
			$filename = "Laporan Prestasi Teknologi Informasi 2014.xls";
			$s='';
			if($_GET['xls'])
			{
			  header('Content-type: application/vnd.ms-excel');
			  header('Content-Disposition: attachment; filename="'.$filename.'"');
			}
			else
			{
			  $s.="<a href='?xls=down'>klik untuk buka dalam bentuk excel</a>";
			}
		?>
			<html>
			
			<center><b>Rekap Prestasi Mahasiswa </b></center><br>
			<center><b>Fakultas Teknologi Informasi</b></center><br>
			<center><b>Universitas Andalas</b></center><br>
			<center><b>Tahun 2014</b></center><br>
		
		<?php 
		$s.="<table border='1'>
			 <tr>
				<th width='5%'>No</th>
				<th>BP</th>
				<th>Nama</th>
				<th width='40%'>Prestasi</th><th>Jurusan</th>
			 </tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>1</td>";
			$s.="\n\t<td>1010961015</td>";
			$s.="\n\t<td>Annisa Permatasari</td>";
			$s.="\n\t<td>tes  tes, padang, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>2</td>";
			$s.="\n\t<td>1010961015</td>";
			$s.="\n\t<td>Annisa Permatasari</td>";
			$s.="\n\t<td>2  jhkllh, uu, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>3</td>";
			$s.="\n\t<td>1010961001</td>";
			$s.="\n\t<td>Khairu Alman</td>";
			$s.="\n\t<td>wewewppppppppp  dsaf, padang, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>4</td>";
			$s.="\n\t<td>1010961015</td>";
			$s.="\n\t<td>Annisa Permatasari</td>";
			$s.="\n\t<td>fdaskfads  bla bla, padang, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>5</td>";
			$s.="\n\t<td>1010961015</td>";
			$s.="\n\t<td>Annisa Permatasari</td>";
			$s.="\n\t<td>1  lomba, padang, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>6</td>";
			$s.="\n\t<td>1010961001</td>";
			$s.="\n\t<td>Khairu Alman</td>";
			$s.="\n\t<td>tes  tes, tes, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>7</td>";
			$s.="\n\t<td>1010961015</td>";
			$s.="\n\t<td>Annisa Permatasari</td>";
			$s.="\n\t<td>Juara III  lomba bla bla, padang, 2014</td>";$s.="\n\t<td>Sistem Informasi</td>";$s.="\n</tr>";	
			$s.="</table>";
			print $s;
		?>	
			</html> 
			<?php
				ob_end_flush();
			?>