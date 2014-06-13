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
	function newtingkat(){
		$('#dlg').dialog('open').dialog('setTitle','Tambah Data');
		$('#fm').form('clear');
		url = 'controller/crud.php?tabel=tingkat&tipe=add';
	}
	
	//Menampilkan form update
	function edittingkat(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Ubah Data');
			$('#fm').form('load',row);
			url = 'controller/crud.php?tabel=tingkat&tipe=update&tingkat_id='+row.tingkat_id;
		}
		else{
			$('#dlg-warning').dialog('open').dialog('setTitle','Pemberitahuan');
			}
		}
	
	//Menampilkan form pencarian
	function searchtingkat(){
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
	function deletetingkat(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Yakin menghapus data tingkatan ini?',function(r){
				if (r){
					$.post('controller/crud.php?tabel=tingkat&tipe=delete',{tingkat_id:row.tingkat_id},function(result){
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
	
	function refreshtingkat(){
		$('#dg').datagrid('load',{});
	}
	</script>
	
	<!-- Tabel Data-->
	<table id="dg" title="Tabel Data Tingkatan Prestasi" class="easyui-datagrid" style="width:400px;height:auto"
			url="controller/crud.php?tabel=tingkat&tipe=view"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="tingkat_nama" width="auto">Tingkatan</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newtingkat()">Tambah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="edittingkat()">Ubah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="deletetingkat()">Hapus</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchtingkat()">Cari</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="refreshtingkat()">Refresh</a>
	</div>
	
	<!-- Form untuk insert dan update-->
	<div id="dlg" class="easyui-dialog" style="width:420px;height:auto;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Tingkatan Prestasi</div>
		<form id="fm" method="post" novalidate>	
			<div class="fitem">
				<label>Tingkatan</label>
				<input name="tingkat_nama" class="easyui-validatebox" required="true"/>
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
		<div class="ftitle">Tingkat</div>
		<form id="fm-search" method="post" novalidate>
			<div class="fitem">
				<label>Keyword</label>
				<input name="keyword" id="keyword" class="easyui-validatebox" placeholder="Nama">
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