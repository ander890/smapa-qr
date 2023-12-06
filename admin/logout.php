<?php
include_once("koneksi.php");

session_destroy();

setToast("success", "berhasil logout");
header("LOCATION:login.php");