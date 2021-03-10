<?php
include_once("koneksi.php");
include "phpqrcode/qrlib.php";

if(!isset($_SESSION['login'])){
    header("LOCATION:login.php");
}

$n = post("nama");

if($n){

    if(isset($_FILES['foto'])){
        $ekstensi_diperbolehkan = array('png','jpg');
        $nama = $_FILES['foto']['name'];
        $x = explode('.', $nama);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['foto']['size'];
        $file_tmp = $_FILES['foto']['tmp_name']; 
            
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 1044070){ 
                move_uploaded_file($file_tmp, '../file/'.$nama);
                $url = BASE_URL."/file/".$nama;
            }else{
                $url = "";
            }
        }else{
            $url = "";
        }
    }else{
        $url = "";
    }

    $unique_id = sha1($nama.time());
    $nama_tumbuhan = $n;
    $deskripsi = post("deskripsi");
    $kategori = post("kategori");
    $jumlah = post("jumlah");

    $isi_teks = $unique_id;
    $logopath = 'img/smapa.png';
    $namafile = $nama_tumbuhan.".png";
    $quality = 'H'; 
    $ukuran = 10; 
    $padding = 4;
    
    QRCode::png($isi_teks,"temp/".$namafile,QR_ECLEVEL_H,$ukuran,$padding);
    $filepath = "temp/".$namafile;
    $QR = imagecreatefrompng($filepath);
    
    $logo = imagecreatefromstring(file_get_contents($logopath));
    imageistruecolor($logo);
    imagetruecolortopalette ($logo, false, 65535);
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    
    $logo_qr_width = $QR_width/3;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;
    
    imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    
    imagepng($QR,$filepath);
    
    $qr_code = BASE_URL."/admin/temp/".$namafile;
    
    $q = mysqli_query($koneksi, "INSERT INTO tumbuhan (unique_id, foto, nama, deskripsi, kategori, jumlah, qr_code) VALUES ('$unique_id', '$url', '$nama_tumbuhan', '$deskripsi', '$kategori', '$jumlah', '$qr_code')");
    
    setToast("success", "Sukses Tambah Tumbuhan");
    header("LOCATION:tumbuhan.php");
    exit;
}

?>
<?php include_once("header.php"); ?>

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="display:inline">Tambah Tumbuhan</h6>


        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <label> Nama </label>
                <input type="text" class="form-control" name="nama" required>
                <br>
                <label> Foto </label>
                <input type="file" class="form-control" name="foto">
                <br>
                <label> Kategori </label>
                <select name="kategori" id="" class="form-control" required>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($row = mysqli_fetch_assoc($q)){
                        echo "<option value='".$row['nama']."'>".$warna." ".$row['nama']."</option>";
                    }

                    ?>

                </select>
                <br>
                <label> Jumlah </label>
                <input type="number" class="form-control" name="jumlah" required>
                <br>
                <label> Deskripsi </label>
                <textarea name="deskripsi" class="form-control" required></textarea>
                <br>
                <button class="btn btn-success btn-block" type="submit"> Simpan </button>
            </form>
        </div>
    </div>

</div>

</div>
<?php include_once("footer.php"); ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script>
    <?php showToast(); ?>
</script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'deskripsi' );
</script>
</body>

</html>