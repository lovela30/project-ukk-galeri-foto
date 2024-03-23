<?php
session_start();
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

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light py-3"  style="background-color: #FFB6C1;">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php"><span class="fw-bolder text-dark">Galeri Foto</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                            <li class="nav-item"><a class="nav-link" href="home .php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="foto.php">Foto</a></li>
                            <li class="nav-item"><a class="nav-link" href="album.php">Album</a></li>
                        </ul>
                    </div>
                    <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"> Keluar </a>
                </div>
            </nav>


<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card mt-2">
        <div class="card-header"> Tambah Album </div>
          <div class="card-body">
          <form action="../config/aksi_album.php" method="POST">
            <label class="form-label"> NamaAlbum</label>
            <input type="text" name="namaalbum" class="form-control" required>
            <label class="form-label"> Deskripsi </label>
            <textarea class="form-control" name="deskripsi" required></textarea>
            <button type="submit" class="btn btn-primary mt-2" name="tambah"> Tambah Data </button>
          </form>
          </div>
      </div>
    </div>

    <div class="col-md-8">
    <div class="card mt-2">
      <div class="card-header"> Data Album </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th> No </th>
                <th> Nama Album </th>
                <th> Deskripsi </th>
                <th> Tanggal</th>
                <th> Aksi </th>
              </tr> 
            </thead>
          <tbody>
            <?php
            $no = 1;
            $userid = $_SESSION['userid'];
            $sql = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
            while($data = mysqli_fetch_array($sql)) {
            ?>
             <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data['namaalbum'] ?></td>
                                        <td><?php echo $data['deskripsi'] ?></td>
                                        <td><?php echo $data['tanggaldibuat'] ?></td>
                                        <td>
        
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['albumid'] ?>"> Edit </button>
                  <div class="modal fade" id="edit<?php echo $data['albumid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel"> Edit Data </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                          <form action="../config/aksi_album.php" method="POST">
                            <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>">
                            <label class="form-label"> Nama Album </label>
                            <input type="text" name="namaalbum" value="<?php echo $data['namaalbum'] ?>" class="form-control" required>
                            <label class="form-label"> Deskripsi </label>
                            <textarea class="form-control" name="deskripsi" required>
                            <?php echo $data['deskripsi']; ?>
                            </textarea>
                         </div>
                         <div class="modal-footer">
                          <button type="submit" name="edit" class="btn btn-primary"> Edit Data </button>
                          </form>
                         </div>
                      </div>
                    </div>
                  </div>
                  
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['albumid'] ?>"> Hapus </button>
                  <div class="modal fade" id="hapus<?php echo $data['albumid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel"> Hapus Data </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                          <form action="../config/aksi_album.php" method="POST">
                            <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>">
                            Apakah anda yakin ingin menghapus data? <strong> <?php echo $data['namaalbum'] ?> </strong>
                         </div>
                         <div class="modal-footer">
                          <button type="submit" name="hapus" class="btn btn-primary"> Hapus Data </button>
                          </form>
                         </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  </div>
</div>


<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-buttom">
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>