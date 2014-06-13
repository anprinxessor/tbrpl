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
	function newUser(){
		$('#dlg').dialog('open').dialog('setTitle','Tambah Data');
		$('#fm').form('clear');
		url = 'controller/crud.php?tabel=user&tipe=add';
	}
	
	//Menampilkan form update
	function editUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Ubah Data');
			$('#fm').form('load',row);
			url = 'controller/crud.php?tabel=user&tipe=update&user_id='+row.user_id;
		}
		else{
			$('#dlg-warning').dialog('open').dialog('setTitle','Pemberitahuan');
			}
		}
	
	//Menampilkan form pencarian
	function searchUser(){
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
	function deleteUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Yakin menghapus data user ini?',function(r){
				if (r){
					$.post('controller/crud.php?tabel=user&tipe=delete',{user_id:row.user_id},function(result){
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
	
	function refreshUser(){
		$('#dg').datagrid('load',{});
	}
	</script>
	
	<!-- Tabel Data-->
	<table id="dg" title="Tabel Data User" class="easyui-datagrid" style="width:auto;height:auto"
			url="controller/crud.php?tabel=user&tipe=view"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>				
				<th field="username" width="auto">Username</th>
				<!--<th field="pass" width="auto">Password</th>-->
				<th field="ket" width="auto">Keterangan</th>
				<th field="user_jenis" width="auto">Jenis User</th>
				<th field="fakultas_nama" width="auto">Fakultas</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Tambah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Ubah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="deleteUser()">Hapus</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchUser()">Cari</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="refreshUser()">Refresh</a>
	</div>
	
	<!-- Form untuk insert dan update-->
	<div id="dlg" class="easyui-dialog" style="width:430px;height:auto;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">USER</div>
		<form id="fm" method="post" novalidate>	
			<div class="fitem">
				<label>Username</label>
				<input name="username" class="easyui-validatebox" required="true"/>
                <label>Password</label>
				<input name="pass" class="easyui-validatebox" required="true" type="password"/>
                <label>Keterangan</label>
				<input name="ket" class="easyui-validatebox" required="true"/>
				<label>Jenis User</label>
				<select name="user_jenis" class="easyui-validatebox" required="true">
					<option value="Admin Universitas">Admin Universitas</option>
					<option value="Admin Fakultas">Admin Fakultas</option>
					<option value="Wakil Rektor 3">Wakil Rektor 3</option>
				</select>
                <label>Fakultas</label>
				<select name="fakultas_id" class="easyui-validatebox" required="true">
					<?php 
						include ("../controller/fakultasController.php");
						$fakultasC = new fakultasController();
						$fakultasC->handleRequest("listFakultas");
					?>
				</select>
			</div>
		</form>
	</div>
	<div id="dlg-buttons" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
	<!-- Form pencarian-->
	<div id="dlg-search" class="easyui-dialog" style="width:400px;height:auto;padding:10px 20px"
		closed="true" buttons="#dlg-buttons-search">
		<div class="ftitle">USER</div>
		<form id="fm-search" method="post" novalidate>
			<div class="fitem">
				<label>Keyword</label>
				<input name="keyword" id="keyword" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Kategori</label>
				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="username" checked="checked"> Username </span>
			</div>
			<div class="fitem">
				<label></label>	
				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="user_jenis" checked="checked"> Jenis User </span>				
			</div>
			<div class="fitem">
				<label></label>	
				<input type="radio" name="kategori" id="kategori" class="easyui-validatebox" value="fakultas_nama" checked="checked"> Nama Fakultas </span>
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