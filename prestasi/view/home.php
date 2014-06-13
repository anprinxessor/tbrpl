<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Prestasi Apps</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet"/>
	<link href="css/bootstrap.min.css" rel="stylesheet"/>
	<link href="css/bootstrap-responsive.css" rel="stylesheet"> 
	<link href="css/docs.css" rel="stylesheet">
	<link href="css/gaya.css"rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/notifikasi.js"></script>
    <style type="text/css">
      body {
        padding-top: 50px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
	
	<script>
		function fakultas() {
			 $("#content").load("view/fakultas.php");
			 pageheader("<h1>Pengelolaan Data Fakultas</h1>");
			 active("fakultas");
		}		
		function jurusan() {
			 $("#content").load("view/jurusan.php");
			 pageheader("<h1>Pengelolaan Data Jurusan</h1>");
			 active("jurusan");
		}
		function dosen() {
			 $("#content").load("view/dosen.php");
			 pageheader("<h1>Pengelolaan Data Dosen</h1>");
			 active("dosen");
		}
		function mahasiswa() {
			 $("#content").load("view/mahasiswa.php");
			 pageheader("<h1>Pengelolaan Data Mahasiswa</h1>");
			 active("mahasiswa");
		}
		function prestasi() {
			 $("#content").load("view/prestasi.php");
			 pageheader("<h1>Pengelolaan Data Prestasi</h1>");
			 active("prestasi");
		}
		function ukm() {
			 $("#content").load("view/ukm.php");
			 pageheader("<h1>Pengelolaan Data UKM</h1>");
			 active("ukm");
		}
		function tingkat() {
			 $("#content").load("view/tingkat.php");
			 pageheader("<h1>Pengelolaan Data Tingkat Prestasi</h1>");
			 active("tingkat");
		}
		function user() {
			 $("#content").load("view/user.php");
			 pageheader("<h1>Pengelolaan Data User</h1>");
			 active("user");
		}
		function laporan() {
			 $("#content").load("view/laporan.php");
			 pageheader("<h1>Laporan Prestasi</h1>");
			 active("laporan");
		}
		function notifikasi() {
			 $( "#notifikasi" ).empty();
			 $("#content").load("view/halamanNotifikasi.php");
			 pageheader("<h1>Notifikasi Prestasi</h1>");
			 $.ajax({url:"controller/notifikasi.php?tipe=updateStatus",success:function(result){
				}});
			 active("notifikasi1");
		}
		function pageheader(judul){
			$( ".page-header" ).empty();
			$( ".page-header" ).append(judul);
		}
		function active(id){
			var menu = ["prestasi", "mahasiswa", "fakultas", "jurusan", "ukm", "tingkat", "user", "laporan", "notifikasi1"];
			for (var i = 0; i < menu.length; i++)
			{
				if(id==menu[i]){
					$( "#"+id ).attr( "class", "active" );
				}
				else{
					$( "#"+menu[i] ).attr( "class", "" );
				}
			}
		}
	</script>
</head>

<body style="padding-top:60px">
	<div class="container">
		<div class="navbar navbar-inverse navbar-fixed-top" >
			<div class="navbar-inner">
				<div class="container-fluid">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="index.php"><b> Sistem Informasi Pengarsipan Prestasi Universitas Andalas</b></a>
					<div class="nav-collapse collapse">
						<p class="navbar-text pull-right">
							Logged in as <a href="" class="navbar-link"><?php echo $_SESSION['ket'];?></a>
						</p>
						<ul class="nav">
							<li class="active"><a href="#"><i class="icon-home"></i> Home</a></li>
							<li ><a href="index.php?logout='1'"><i class="icon-off icon-white"></i> Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="span3 bs-docs-sidebar">
				<ul class="nav nav-list bs-docs-sidenav">
						<?php
							$jenis = $_SESSION['user_jenis'];
							$akses = new aksesController();
							$akses->menu($jenis);
						?>
				</ul>
			</div>
			<div class="span9">
				<div class="mini-layout">
					<div class="page-header">
						<h1>Halaman Utama</h1>
					</div>
					<div id="content">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<footer>
		<div class="navbar navbar-inverse navbar-fixed-bottom" >
			<div class="navbar-inner">
				<a class="brand" href="index.php"><font size="2pt">&nbsp;&copy; Kelompok 5 Rekayasa Perangkat Lunak, Sistem Informasi, FTI, Unand - 2014</font></a>
			</div>
		</div>
	</footer>
	
  </body>
</html>
