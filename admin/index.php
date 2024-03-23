<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
  echo "<script>
    alert('Anda Belum Login!');
    location.href='../index.php'; 
  </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title> Website Galeri Foto </title>
   <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"54/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light py-3" style="background-color: #FFB6C1;">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php"><span class="fw-bolder text-dark">Galeri Foto</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navbar-nav me-auto">
                          &thinsp;&thinsp;&thinsp;&thinsp;
                            <a class="nav-link" href="home.php">Home</a>
                            <a class="nav-link" href="foto.php">Foto</a>
                            <a class="nav-link" href="album.php">Album</a>
                    </div>

                    <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"> Keluar </a>
                </div>
              </div>
            </nav>


<div class="container mt-3">
  <div class="row">
    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM foto");
  while($data = mysqli_fetch_array($query)) {
  ?>

  <div class="col-md-3 mb-2">
    <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid']?>">

    <div class="card mb-2">
      <img src="../assets/img/<?php echo $data ['lokasifile'] ?>" class="card-img-top" title="<?php echo $data ['judulfoto']?>"style="height: 12rem;">
      <div class="card-footer text-center">

         <?php
                    $fotoid = $data['fotoid'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-up m-1"></i></a>
                    <?php } else { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-up m-1"></i></a>
                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($like). ' ';
                    ?>

                    &thinsp;
                    <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid']?>"><i class="fa-regular fa-comment"></i></a>
                    <?php
                    $jmlkomen=mysqli_query($koneksi,"SELECT *FROM komentarfoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($jmlkomen), 'komentar';
                    ?>
                    </div>
                   </div>
  </a>
      <!-- Modal -->
      <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
          <img src="../assets/img/<?php echo $data['lokasifile']?>" class="card-img-top" title="<?php echo $data['judulfoto']?>">
          </div>
          <div class="col-md-4">
            <div class="m-2">
              <div class="overflow-auto">
                <div class="sticky-top">
                  <br><a href="../assets/img/<?php echo $data['lokasifile'] ?>" download="download"><i class="fa-solid fa-download fa-xl" style="color:#001100;"></i></a><br></a></br>
                  <strong><?php echo $data['judulfoto'] ?></strong>
                  <span class="badge bg-secondary"><?php echo $data['userid'] ?></span>
                  <span class="badge bg-secondary"><?php echo $data['tanggalunggah'] ?></span>
                  <span class="badge bg-primary"><?php echo $data['albumid'] ?></span>
                </div>
                <hr>
                <p align="left">
                  <?php echo $data['deskripsifoto'] ?>
                </p>
                <hr>
                <?php
                $fotoid= $data ['fotoid'];
                $komentar= mysqli_query($koneksi,"SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.UserID=user.UserID WHERE komentarfoto.FotoID='$fotoid'");
                while($row=mysqli_fetch_array($komentar)) { 
                ?>
                <p align="left">  
                  <strong> <?php echo $row ['namalengkap'] ?></strong>
                  <?php echo $row['IsiKomentar'] ?>
                </p>
                <?php } ?>
                <hr>
                <div class="sticky-bottom">
                  <form action="../config/proses_komentar.php" method="POST">
                    <div class="input-group">
                      <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']?>">
                      <input type="text" name="isikomentar" class="form-control" placeholder="Tambah Komentar">
                      <div class="input-group-prepend"></div>
                      <button type="submit" name="kirimkomentar" class="btn btn-outline-secondary"><i class="fa-regular fa-paper-plane" style="color: #001100;"></i></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

		</div>
    <?php } ?>

<?php  ?>

  </div>
</div>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>