<?php session_start();?>
	<link rel="stylesheet" type="text/css" href="css/easyui.css">
	<link rel="stylesheet" type="text/css" href="css/icon.css">
	<link rel="stylesheet" type="text/css" href="css/demo.css">
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			color:#666;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
	</style>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
	<script type="text/javascript">
	var counter;
	//Menampilkan form insert
	function newPrestasi(){
		$('#dlg').dialog('open').dialog('setTitle','Tambah Data');
		$('#fm').form('clear');
		$('.id_dtl').remove();
		url = 'controller/crud.php?tabel=prestasi&tipe=add';
		counter = 1;
	}

	//Menampilkan form update
	function editPrestasi(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Ubah Data');
			$('#fm').form('load',row);
			url = 'controller/crud.php?tabel=prestasi&tipe=update&prestasi_id='+row.prestasi_id;
		}
		else{
			$('#dlg-warning').dialog('open').dialog('setTitle','Pemberitahuan');
			}
		}
	
	//Menampilkan form pencarian
	function searchPrestasi(){
		$('#dlg-search').dialog('open').dialog('setTitle','Cari Data');
		$('#fm-search').form('clear');
	}
	
	//Menampilkan hasil pencarian
	function viewSearch(){
		$('#dg').datagrid('load',{
			keyword: $('#keyword').val(),
			kategori: $('input[name=kategori]:checked' ).val()
		});
	}
	
	//menampilkan detail prestasi
	function detailPrestasi() {
			var row = $('#dg').datagrid('getSelected');
			if(row){
				$('#dg-detail').datagrid('load',{
				prestasi_id: row.prestasi_id
				});
				$('#prestasi_id').html(row.prestasi_id+" - "+row.nama_kegiatan);
			}
			else{
				$('#dlg-warning').dialog('open').dialog('setTitle','Warning');
			}
		}
		
	// penambahan bp dan upload
		function add(){
			//alert("tes");
			var prestasi_id = $('#prestasi_id').val();
			var div_select = "#data"+counter;
			$("<div class=\"fitem\" id='mhs"+counter+"'><label class='id_dtl'>Mhs-"+counter+"</label><span><input class='id_dtl' id='data"+counter+"' name='data[]' placeholder='BP' /><input name='foto[]' class='id_dtl' id='foto"+counter+"' type='file'></span></div><br>").appendTo('#peserta');
			counter++;
		}
		
	//Menyimpan data dari form insert		
	function saveData(){
		var nim , foto;
		if(counter>1){
			var nim_array = new Array();
			var foto_array = new Array();
			var i,j,k;
			var n = counter-1;
			
			// memasukan value inventaris ke array
				for(i=0;i<n; i++)
				{	
					j=i+1;
					nim  = "#data"+j;
					nim_array[i] = $(nim).val();
					foto  = "#foto"+j;
					foto[i] = $(foto).val();
				}
		}
		
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					$('#dlg').dialog('close');		// close the dialog
					$('#dg').datagrid('reload');	// reload the user data
				} else {
					$.messager.show({
						title: 'Error',
						msg: result.msg
					});
				}
			}
		});
	}
	
	//Menghapus data
	function deletePrestasi(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Yakin menghapus data Prestasi ini?',function(r){
				if (r){
					$.post('controller/crud.php?tabel=prestasi&tipe=delete',{prestasi_id:row.prestasi_id},function(result){
						if (result.success){
							$('#dg').datagrid('reload');	// reload the user data
						} else {
							$.messager.show({	// show error message
								title: 'Error',
								msg: result.msg
							});
						}
					},'json');
				}
			});
		}
		else{
			$('#dlg-warning').dialog('open').dialog('setTitle','Pemberitahuan');
		}
	}
	
	function refreshPrestasi(){
		$('#dg').datagrid('load',{});
	}
	</script>
	
	<!-- Tabel Header-->
	<table id="dg" title="Header" class="easyui-datagrid" style="width:850px;height:auto"
			url="controller/crud.php?tabel=prestasi&tipe=view"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
            <th field="nama_kegiatan" width="auto">Nama Kegiatan</th>
                <th field="peringkat" width="auto">Peringkat</th>
                <th field="tempat" width="auto">Tempat</th>
                <th field="tahun" width="auto">Tahun</th>
                <th field="tgl_dari" width="auto">Tanggal Dari</th>
                <th field="tgl_sampai" width="auto">Tanggal Sampai</th>
                <th field="tingkat_nama" width="auto">Tingkat</th>
                <th field="tingkat_ket" width="auto">Keterangan Tingkat</th>
                <th field="prestasi_jenis" width="auto">Jenis Prestasi</th>
                <th field="deskripsi" width="auto">Deskripsi</th>
                <th field="status_ukm" width="auto">Status UKM</th> 
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<?php
			include ('../controller/prestasiController.php');
			$prestasiC = new prestasiController();
			$prestasiC->toolbar($_SESSION['user_jenis']);
		?>
	</div>
	<br>
	
	<!-- Table Detail-->
	<table id="dg-detail" title="Detail" class="easyui-datagrid" style="width:500px;height:auto"
			url="controller/crud.php?tabel=prestasi&tipe=viewDetail"
			toolbar="#toolbar-detail" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="nim" width="auto">BP</th>
				<th field="civitas_akademik_nama" width="auto">Nama</th>
				<th field="link_foto" width="auto">Sertifikat</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar-detail">
		<b><label id="prestasi_id"></label></b>
	</div>
	
	<!-- Form untuk insert dan update-->
	<div id="dlg" class="easyui-dialog" style="width:450px;height:400px;padding:10px 20px;overflow:auto;"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Prestasi</div>
		<form id="fm" method="post" novalidate enctype="multipart/form-data">	
			<div class="fitem">
				<label>Prestasi ID</label>
				<input name="prestasi_id" id="prestasi_id"class="easyui-validatebox" required="true"/>
			</div>
			<div class="fitem">
				<label>Nama Kegiatan</label>
				<input name="nama_kegiatan" class="easyui-validatebox" required="true"/>
			</div>
			<div class="fitem">
				<label>Peringkat</label>
				<input name="peringkat" class="easyui-validatebox" required="true"/>
			</div>
            <div class="fitem">
				<label>Tempat</label>
				<input name="tempat" class="easyui-validatebox" required="true"/>
			</div>
            <div class="fitem">
				<label>Tahun</label>
				<input name="tahun" class="easyui-validatebox" required="true"/>
			</div>
            <div class="fitem">
				<label>Tgl Dari</label>
				<input name="tgl_dari" class="easyui-validatebox" type="date" required="true"/>
			</div>
            <div class="fitem">
				<label>Tgl Sampai</label>
				<input name="tgl_sampai" type="date" class="easyui-validatebox"/>
			</div>
			<div class="fitem">
				<label>Tingkat</label>
				<select name="tingkat_id" class="easyui-validatebox" required="true">
					<?php 
						include ("../controller/tingkatController.php");
						$tingkatC = new tingkatController();
						$tingkatC->handleRequest("listtingkat");
					?>
				</select>
			</div>            <div class="fitem">
				<label>Keterangan Tingkat</label>
				<input name="tingkat_ket" class="easyui-validatebox"/>
			</div>
            <div class="fitem">
				<label>Jenis Prestasi</label>
				<select name="prestasi_jenis" class="easyui-validatebox" required="true">
                	<option value="Akademik">Akademik</option>
                	<option value="Non Akademik">Non Akademik</option>
                </select>
			</div>
            <div class="fitem">
				<label>Deskripsi</label>
				<input name="deskripsi" class="easyui-validatebox" type="text"/>
			</div>
			<div class="fitem">
				<label>Status UKM</label>
				<select name="status_ukm" class="easyui-validatebox" required="true">
                	<option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                 </select>
			</div>
			<hr>
			<div id="peserta"></div>
			<button iconCls="icon-add" onclick="add()" class="easyui-linkbutton">Tambah
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
	
	<!-- Form pencarian-->
	<div id="dlg-search" class="easyui-dialog" style="width:400px;height:auto;padding:10px 20px"
		closed="true" buttons="#dlg-buttons-search">
		<div class="ftitle">PRESTASI</div>
		<form id="fm-search" method="post" novalidate>
			<div class="fitem">
				<label>Keyword</label>
				<input name="keyword" id="keyword" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Kategori</label>
				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="tahun" checked="checked"> Tahun</span>
			</div>
			<div class="fitem">
				<label></label>
				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="prestasi_jenis" checked="checked"> Jenis Prestasi</span>
			</div>
			
		</form>
	</div>
	<div id="dlg-buttons-search">
		<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="viewSearch()">Search</a> 
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-search').dialog('close')">Close</a>
	</div>
	
	<!-- Dialog warning-->
	<div id="dlg-warning" class="easyui-dialog" style="width:300px;height:150px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Pemberitahuan</div>
			<center><b>Silahkan klik salah 1 DATA di tabel</b></center>
		</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="javascript:$('#dlg-warning').dialog('close')">OK</a>
	</div>	