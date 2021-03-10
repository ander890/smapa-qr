<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "smapa";

$koneksi = mysqli_connect($host, $username, $password, $db) or die("GAGAL KONEKSI DENGAN DB");

define("BASE_URL", "http://localhost/smapa");
session_start();


function post($var){
    global $koneksi;
    $p = isset($_POST[$var]) ? $_POST[$var] : null;
    $p = mysqli_real_escape_string($koneksi, $p);
    return $p;
}

function get($var){
    global $koneksi;
    $p = isset($_GET[$var]) ? $_GET[$var] : null;
    $p = mysqli_real_escape_string($koneksi, $p);
    return $p;
}

function setToast($style, $toast){
    $_SESSION['toast'] = $toast;
    $_SESSION['style'] = $style;
}

function showToast(){
    $toast = isset($_SESSION["toast"]) ? $_SESSION["toast"] : null;
    $style = isset($_SESSION["style"]) ? $_SESSION["style"] : null;

    if($toast && $style){
        if($style == "error"){
            echo "toastr.error('".$toast."')";
        }

        if($style == "success"){
            echo "toastr.success('".$toast."')";
        }

        unset($_SESSION['toast']);
        unset($_SESSION['style']);
    }
}