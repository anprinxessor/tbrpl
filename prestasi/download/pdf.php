
			<?php 
			require_once('../html2fpdf/html2fpdf.php');          // agar dapat menggunakan fungsi-fungsi html2pdf
			ob_start();                             // memulai buffer
			error_reporting(1);                     // turn off warning for deprecated functions
			$pdf= new HTML2FPDF();                  // membuat objek HTML2PDF
			$pdf->DisplayPreferences('Fullscreen'); // set preferensi tampilan pdf
			?>
			
			<html>
			
			<center><b>Rekap Prestasi Mahasiswa </b></center><br>
			
			<center><b>Universitas Andalas</b></center><br>
			<center><b>Tahun 2013</b></center><br>
		
		<?php 
		$s.="<table border='1'>
			 <tr>
				<th width='5%'>No</th>
				<th>BP</th>
				<th>Nama</th>
				<th width='40%'>Prestasi</th><th>Jurusan</th><th>Fakultas</th>
			 </tr>";
			$s.="\n<tr>";
			$s.="\n\t<td>1</td>";
			$s.="\n\t<td>1010961015</td>";
			$s.="\n\t<td>Annisa Permatasari</td>";
			$s.="\n\t<td>Juara III  Web Design Sisfotime, Telkom University, Bandung, 2013</td>";
				$s.="\n\t<td>Sistem Informasi</td>";
				$s.="\n\t<td>Teknologi Informasi</td>";$s.="\n</tr>";	
			$s.="</table>";
			print $s;
		?>	
			</html> 
				<?php
				$html=ob_get_contents();                // mengambil data dengan format html, dan disimpan di variabel
				ob_end_clean();                         // mengakhiri buffer dan tidak menampilkan data dalam format html
				$pdf->addPage();                        // menambah halaman di file pdf
				$pdf->WriteHTML($html);                 // menuliskan data dengan format html ke file pdf
				$pdf->Output('Laporan Prestasi  2013.pdf','D');         // mengeluarkan file pdf dengan nama tes001.pdf dalam bentuk file yang bisa di download
				?>
			