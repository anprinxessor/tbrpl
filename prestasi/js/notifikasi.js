var x = 1;

function cek(){
    $.ajax({
        url: "controller/notifikasi.php?tipe=jumlahNotifikasi",
        cache: false,
        success: function(msg){
            $("#notifikasi").html(msg);
        }
    });
    var waktu = setTimeout("cek()",30000);
}

$(document).ready(function(){
    cek();
    $("#notifikasi").click(function(){
        //ajax untuk menampilkan pesan yang belum terbaca
        $.ajax({
            url: "controller/notifikasi.php?tipe=lihatNotifikasi",
            cache: false,
            success: function(msg){
                $("#konten-info").html(msg);
            }
        });

    });
    
});


