<?php 
	session_start();
	$fakultas = $_SESSION['fakultas_id'];
	$user = $_SESSION['user_jenis'];
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
	$( "#area" ).change(function() {
		var area = $( "#area" ).val();
		if(area=="fakultas"){
			$( "#1" ).hide();
			$( "#fakultas_id" ).show();
		}
	});
	function downloadLaporan(){
		var area = $( "#area" ).val();
		var tahun = $( "#tahun" ).val();
		var prestasi_jenis = $( "#prestasi_jenis" ).val();
		var file = $( "#file" ).val();
		var fakultas_id="";
		if(area=="fakultas" || area==""){
			fakultas_id = $( "#fakultas_id" ).val();
			if (fakultas_id==null || fakultas_id=="") {
				alert("Pilih Fakultas");
				return false;
			}
		}
		$.ajax({
		  type: "POST",
		  url: "controller/crud.php?tabel=prestasi&tipe=laporan",
		  data: { area: area, tahun: tahun, prestasi_jenis:prestasi_jenis, file:file, fakultas_id:fakultas_id}
		})
		  .done(function( html ) {
    $( "#results" ).append( html );
  });
	}
</script>
</head>

<body>  
	<form method="post" id="laporan" onsubmit="downloadLaporan()">
	<table>
		<?php
			if($user!="Admin Fakultas"){
				?>
				<tr>
					<td><b>Area </b></td>
					<td>
						<select name="area" id="area" required="true">
							<option value="semua">Semua</option>
							<option value="ukm">UKM</option>
							<option value="fakultas">Fakultas</option>
						</select>
					</td>
					<td>
						<select name="fakultas_id" id="fakultas_id" required="true" style="display:none">
						<option value="">Pilih Fakultas</option>
							<?php 
								include ("../controller/fakultasController.php");
								$fakultasC = new fakultasController();
								$fakultasC->handleRequest("listFakultas");
							?>
						</select>
					</td>
				</tr>
				<?php
			}
			else{
				echo"<input type='hidden' id='fakultas_id' value='".$fakultas."'>";
				echo"<input type='hidden' id='area' value=''>";
			}
		?>
		<tr>
			<td><b>Tahun </b></td>
			<td>
				<select name="tahun" id="tahun"required="true">
                	<?php 
						$tahunmax = date("Y"); 
						for($tahun=2010;$tahun<=$tahunmax;$tahun++){
							echo "<option value=".$tahun.">".$tahun."</option>";
						}
					?>
                 </select>
			</td>
		</tr>
		<tr>
			<td><b>Jenis Prestasi</b></td>
			<td>
				<select name="prestasi_jenis" id="prestasi_jenis" required="required">
                	<option value="semua">Semua</option>
                    <option value="Akademik">Akademik</option>
                    <option value="Non Akademik">Non Akademik</option>
                 </select>
			</td>
		</tr>
		<tr>
			<td><b>Tipe File</b></td>
			<td>
				<select name="file" id="file" required="true">
                	<option value="pdf">PDF </option>
                    <option value="excel">Excel</option>
                 </select>
			</td>
		</tr>
		<tr>
			<td><input class="btn btn-sm btn-primary" type="button" value="Download" onclick="downloadLaporan()"></td>
		</tr>
	</table>
	<div id="results"></div>
</form>

</body>
</html>
