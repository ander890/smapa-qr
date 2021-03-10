<?php
include_once("koneksi.php");

$id = get("id");
$q = mysqli_query($koneksi, "SELECT * FROM tumbuhan WHERE id='$id'");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Poppins', sans-serif;
        }

        .myContainer {
            display: grid;
            page-break-inside: avoid;
        }

    </style>
</head>
<body>
    <div class="myContainer">
        <div class="row">
            <?php
            while($row = mysqli_fetch_assoc($q)){
                echo "<div class='col-md-6'>";
                echo "<center><img style='width:400px' src='".$row['qr_code']."'></center>";
                echo "<center><b>".$row['nama']."</b></center>";
                echo "<center>https://scan.dvlprs.xyz</center>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
<script>
    window.print();
</script>
</html>