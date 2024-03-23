<?php  
session_start();
include 'koneksi.php';
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

$cekbatalsuka = mysqli_query($koneksi,"SELECT * FROM unlikefoto WHERE fotoid='$fotoid' AND userid='$userid'");

if (mysqli_num_rows($cekbatalsuka) == 1){
    while($row = mysqli_fetch_array($cekbatalsuka)){
        $unlikeid = $row['unlikeid'];
        $query = mysqli_query($koneksi, "DELETE FROM unlikefoto WHERE unlikeid='$unlikeid'");

        echo "<script>
        location.href ='../admin/home.php';
        </script>";
    }
} else{
    $tanggalunlike = date('Y-m-d');
    $query = mysqli_query($koneksi, "INSERT INTO unlikefoto VALUES('','$fotoid','$userid','$tanggalunlike')");

    echo"<script>
    location.href = '../admin/home.php';
    </script>";
}

?>