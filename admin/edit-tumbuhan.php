<?php
include_once("koneksi.php");
include "phpqrcode/qrlib.php";

if(!isset($_SESSION['login'])){
    header("LOCATION:login.php");
}

$id = get("id");


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
                $foto_final = BASE_URL."/file/".$nama;
            }else{
                $foto_final = post("foto_old");
            }
        }else{
            $foto_final = post("foto_old");
        }
    }else{
        $foto_final = post("foto_old");
    }

    $nama_tumbuhan = post("nama");
    $foto = $foto_final;
    $kategori = post("kategori");
    $jumlah = post("jumlah");
    $deskripsi = post("deskripsi");

    $q = mysqli_query($koneksi, "UPDATE tumbuhan SET nama='$nama_tumbuhan', foto='$foto', kategori='$kategori', jumlah='$jumlah', deskripsi='$deskripsi' WHERE id='$id'");

    if($q){
        setToast("success", "Sukses Update Tumbuhan");
    }else{
        setToast("error", "Gagal upload");
    }
}

$q1 = mysqli_query($koneksi, "SELECT * FROM tumbuhan WHERE id='$id'");
$r = mysqli_fetch_assoc($q1);
?>
<?php include_once("header.php"); ?>

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="display:inline">Edit Tumbuhan</h6>


        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <label> Nama </label>
                <input type="text" class="form-control" name="nama" value="<?= $r['nama'] ?>" required>
                <br>
                <label> Foto </label>
                <br>
                <img style="width:200px" src="<?= $r['foto'] ?>">
                <br><br>
                <input type="file" class="form-control" name="foto">
                <input type="hidden" class="form-control" name="foto_old" value="<?= $r['foto'] ?>" required>
                <br>
                <label> Kategori </label>
                <select name="kategori" id="" class="form-control" required>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($row = mysqli_fetch_assoc($q)){
                        if($row['nama'] == $r['kategori']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                        echo "<option value='".$row['nama']."' ".$selected.">".$row['nama']."</option>";
                    }

                    ?>

                </select>
                <br>
                <label> Jumlah </label>
                <input type="number" class="form-control" name="jumlah" value="<?= $r['jumlah'] ?>" required>
                <br>
                <label> Deskripsi </label>
                <textarea name="deskripsi" class="form-control" required><?= $r['deskripsi'] ?></textarea>
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