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
	//Menampilkan form insert
	function newMahasiswa(){
		$('#dlg').dialog('open').dialog('setTitle','Tambah Data');
		$('#fm').form('clear');
		url = 'controller/crud.php?tabel=mahasiswa&tipe=add';
	}
	
	//Menampilkan form update
	function editMahasiswa(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Ubah Data');
			$('#fm').form('load',row);
			url = 'controller/crud.php?tabel=mahasiswa&tipe=update&civitas_akademik_id='+row.civitas_akademik_id;
		}
		else{
			$('#dlg-warning').dialog('open').dialog('setTitle','Pemberitahuan');
			}
		}
	
	//Menampilkan form pencarian
	function searchMahasiswa(){
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
		
	//Menyimpan data dari form insert		
	function saveData(){
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				//alert(result);
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
	function deleteMahasiswa(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Yakin menghapus data mahasiswa ini?',function(r){
				if (r){
					$.post('controller/crud.php?tabel=mahasiswa&tipe=delete',{civitas_akademik_id:row.civitas_akademik_id},function(result){
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
	
	function refreshMahasiswa(){
		$('#dg').datagrid('load',{});
	}
	</script>
	
	<!-- Tabel Data-->
	<table id="dg" title="Tabel Data Mahasiswa" class="easyui-datagrid" style="width:auto;height:auto"
			url="controller/crud.php?tabel=mahasiswa&tipe=view"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
              	<th field="nim" width="auto">NIM</th>
				<th field="civitas_akademik_nama" width="auto">Nama</th>
				<th field="tmpt_lhr" width="auto">Tempat Lahir</th>
				<th field="tgl_lhr" width="auto">Tanggal Lahir</th>
				<th field="alamat" width="auto">Alamat</th>
				<th field="hp" width="auto">Nomor Kontak</th>
				<th field="email" width="auto">Email</th>
				<th field="jurusan_nama" width="auto">Jurusan</th>                
				<th field="ukm_nama" width="auto">UKM</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMahasiswa()">Tambah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMahasiswa()">Ubah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="deleteMahasiswa()">Hapus</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchMahasiswa()">Cari</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="refreshMahasiswa()">Refresh</a>
	</div>
	
	<!-- Form untuk insert dan update-->
	<div id="dlg" class="easyui-dialog" style="width:420px;height:auto;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Mahasiswa</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				  <label>NIM</label>
				  <input name="nim" class="easyui-validatebox" required="true" maxlength="10"/>
			</div>
       		<div class="fitem">
				  <label>Nama</label>
				  <input name="civitas_akademik_nama" class="easyui-validatebox" required="true"/>
			</div>
            <div class="fitem"></div>
			<div class="fitem">
				<label>Tempat Lahir</label>
				<input name="tmpt_lhr" class="easyui-validatebox" required="true"/>
			</div>
			<div class="fitem">
				<label>Tanggal Lahir</label>
				<input name="tgl_lhr" type="date" class="easyui-validatebox" required="true"/>
			</div>
			<div class="fitem">
				<label>Alamat</label>
				<textarea name="alamat" class="easyui-validatebox" required="true"/>
			</div>			
            <div class="fitem">
				<label>Nomor Telepon</label>
				<input name="telp" class="easyui-validatebox" maxlength="12"/>
			</div>			
            <div class="fitem">
				<label>Nomor HP</label>
				<input name="hp" class="easyui-validatebox" required="true" maxlength="12"/>
			</div>			
            <div class="fitem">
				<label>Email</label>
				<input name="email" class="easyui-validatebox" validType="email"/>
			</div>
			<div class="fitem">
				<label>Jurusan</label>
				<select name="jurusan_id" class="easyui-validatebox" required="true">
					<?php 
						include ("../controller/jurusanController.php");
						$jurusanC = new jurusanController();
						$jurusanC->handleRequest("listJurusan");
					?>
				</select>
			</div>
			<div class="fitem">
				<label>UKM</label>
				<select name="ukm_id" class="easyui-validatebox" required="true">
					<?php 
						include ("../controller/ukmController.php");
						$ukmC = new ukmController();
						$ukmC->handleRequest("listUkm");
					?>
				</select>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
	
	<!-- Form pencarian-->
	<div id="dlg-search" class="easyui-dialog" style="width:400px;height:auto;padding:10px 20px"
		closed="true" buttons="#dlg-buttons-search">
		<div class="ftitle">Mahasiswa</div>
		<form id="fm-search" method="post" novalidate>
			<div class="fitem">
				<label>Keyword</label>
				<input name="keyword" id="keyword" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Kategori</label>
				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="nim" checked="checked"> NIM</span>
			</div>
			<div class="fitem">
				<label></label>				
  				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="civitas_akademik_nama" checked="checked"> Nama Mahasiswa</span>
			</div>
			<div class="fitem">
				<label></label>				
  				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="jurusan_nama" checked="checked"> Nama Jurusan</span>
			</div>
			<div class="fitem">
				<label></label>				
  				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="ukm_nama" checked="checked"> Nama UKM</span>
			</div>
		</form>
	</div>
	<div id="dlg-buttons-search">
		<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="viewSearch()">Search</a> 
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-search').dialog('close')">Close</a>
	</div>
	
	<!-- Dialog warning-->
	<div id="dlg-warning" class="easyui-dialog" style="width:300px;height:170px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Pemberitahuan</div>
			<center><b>Silahkan klik salah 1 DATA di tabel</b></center>
		</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="javascript:$('#dlg-warning').dialog('close')">OK</a>
	</div>	