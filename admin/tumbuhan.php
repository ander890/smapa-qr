<?php
include_once("koneksi.php");

if(!isset($_SESSION['login'])){
    header("LOCATION:login.php");
}

$action = get("action");
$id = get("id");

if($action && $id){
    $q = mysqli_query($koneksi, "DELETE FROM tumbuhan WHERE id='$id'");
    setToast("success", "Sukses Hapus Tumbuhan");
    header("LOCATION:tumbuhan.php");
    exit;
}

?>
<?php include_once("header.php"); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tumbuhan</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="display:inline">Tumbuhan</h6>
            <a type="text" target="_blank" style="margin:5px" class="btn btn-primary float-right" href="print.php">
                Print QR Code
            </a>
            <a type="text" style="margin:5px" class="btn btn-success float-right" href="tambah-tumbuhan.php">
                Tambah Tumbuhan
            </a>


        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tumbuhan</th>
                            <th>QR Code</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM tumbuhan");
                        $no = 1;
                        while($row = mysqli_fetch_assoc($query)){
                            echo "<tr>";
                            echo '<td>'.$no.'</td>';
                            echo '<td>'.$row['nama'].'</td>';
                            echo '<td><img style="width:200px" src="'.$row['qr_code'].'"></td>';
                            echo '<td>'.$row['jumlah'].'</td>';
                            echo '<td><a class="btn btn-info" style="margin:5px" target="_blank" href="print-single.php?id='.$row['id'].'">Print QR</a><a class="btn btn-primary" style="margin:5px" href="edit-tumbuhan.php?id='.$row['id'].'">Edit</a><a class="btn btn-danger"  style="margin:5px" href="?action=hapus&id='.$row['id'].'">Hapus</a></td>';
                            echo '</tr>';
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <label> Nama Kategori </label>
            <input type="text" class="form-control" name="nama">
            <br>
            <label> Warna Kategori </label>
            <input type="color" class="form-control" name="warna">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Simpan</button>
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
</body>

</html>