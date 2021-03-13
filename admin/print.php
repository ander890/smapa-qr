<?php
include_once("koneksi.php");

$q = mysqli_query($koneksi, "SELECT * FROM tumbuhan");


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
            page-break-inside: avoid;
        }

        body {
          background:white;
        }

        * {
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
        }

        .span  {
          border:1px solid black;
          background: white;
          text-align: center;
          border-radius:50%;
          display:inline-block;
          width:655px;
          height: 655px;
          padding: 80px;
          margin: 10px;
        }

        img {
          display:block;
        }

    </style>
</head>
<body>
    <div class="myContainer">
        <div>
            <?php
            $c = 1;
            while($row = mysqli_fetch_assoc($q)){
                $count = $row['jumlah'];
                $nama = $row['nama'];

                echo "<span id='capture".$c."' data-nama='".$nama."' data-jumlah='".$count."' class='span'>";
                echo "<center><img style='width:450px' src='".$row['qr_code']."'></center>";
                echo "<center><a style='font-weight:bold;font-size:35px'>".$row['nama']."</a></center>";
                echo "<center><a style='font-size:30px'>scan.dvlprs.xyz</a></center>";
                echo "</span>";

                $c++;
            }
            ?>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha512-s/XK4vYVXTGeUSv4bRPOuxSDmDlTedEpMEcAQk0t/FMd9V6ft8iXdwSBxV0eD60c6w/tjotSlKu9J2AAW1ckTA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $(function() {
      $("#btnSave").click(function() {
          html2canvas($("#capture1"), {
              onrendered: function(canvas) {
                var a = document.createElement('a');
                // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                a.download = 'somefilename.jpg';
                a.click();
              }
          });
      });
  });
    </script>
</body>
<script>
    //window.print();
</script>
</html>
