<?php
include_once("admin/koneksi.php");

$r = get("r");

$q = mysqli_query($koneksi, "SELECT * FROM tumbuhan WHERE unique_id='$r'");
$row = mysqli_fetch_assoc($q);
$c = [
    "#f44336",
    "#9c27b0",
    "#3f51b5",
    '#2196f3',
    "#4caf50",
    "#ffc107",
    "#ff5722",
    "#795548",
    "#9e9e9e",
  ];
  
  shuffle($c);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;1,400&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jfif" href="gbt.jfif" />
    <title>SMA Neger 4 Adiwiyata</title>
    <style>

    body{
      font-family: 'Poppins', sans-serif;
      background-color: <?= $c[0] ?>;
    }

    .footer {
      position: fixed;
      left: 0%;
      bottom: 0px;
      width: 100%;
      background-color: transparant;
      color: white;
      text-align: center;
    }


    </style>
  </head>
  <body>
    <div class="container">
      <div class="card" style="margin-top:10%">
        <div class="card-header">
          <center><h3><?= $row['nama'] ?></h3></center>
        </div>
        <div class="card-body">
            <?php
            if($row['foto'] != ""){
                echo "<center><img style='width:200px' src='".$row['foto']."'></center><br>";
            }

            ?>
          <h5 class="card-text"><?= $row['deskripsi'] ?></h5>
        </div>
      </div>

    </div>

    <footer class="footer"><a class="btn btn-block btn-secondary" style="border-radius: 0 !important;">&copy; SMA Negeri 4 Semarang</a></footer>


  </body>
</html>
