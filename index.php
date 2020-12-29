<?php
// Start the session
session_start();

if(isset($_SESSION['sukses'])) {
  echo "<script> alert('Perintah berhasil dieksekusi'); </script>";
}

if(isset($_SESSION['error'])) {
  echo "<script> alert(".$_SESSION['error']."); </script>";
}

// remove all session variables
session_unset();
// destroy the session
session_destroy();

include 'koneksi.php';
$selectBuku = "SELECT * FROM buku";
$resultBuku = $conn->query($selectBuku);

$selectBukuLagi = "SELECT * FROM buku ORDER BY id DESC LIMIT 4";
$resultBukuLagi = $conn->query($selectBukuLagi);

$selectReview = "SELECT * FROM review";
$resultReview = $conn->query($selectReview);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Hiroto Template">
    <meta name="keywords" content="Hiroto, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Galeri Buku</title>

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__nav__option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="header__logo">
                            <a href="./index.php"><img src="img/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="header__nav">
                            <div class="header__nav__widget">
                                <a href="#" data-toggle="modal" data-target="#bukuModal">Tambah Buku <span class="icon_book"></span></a>
                                <a href="#" data-toggle="modal" data-target="#reviewModal">Tambah Review <span class="icon_comment"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="canvas__open">
                    <span class="fa fa-bars"></span>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Modal Buku-->
    <div class="modal fade" id="bukuModal" tabindex="-1" role="dialog" aria-labelledby="bukuModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bukuModalLabel">Tambah Buku</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="tambah-buku.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input type="text" class="form-control" name="judul" id="judul" required placeholder="Judul Buku">
              </div>
              <div class="form-group">
                <label for="kategori">Kategori Buku</label>
                <select class="form-control" name="kategori" id="kategori" required>
                  <option value="">Pilih Kategori</option>
                  <option value="Fiksi">Fiksi</option>
                  <option value="Non Fiksi">Non Fiksi</option>
                </select>
              </div>
              <div class="form-group">
                <label for="sampul">Sampul</label>
                <input type="file" class="form-control-file" name="sampul" id="sampul" placeholder="Sampul Buku"  accept="image/*" aria-describedby="fileHelpId" required>
                <small id="fileHelpId" class="form-text text-muted">Maximal 1 MB aja yah</small>
              </div>
              <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea class="form-control" name="sinopsis" required id="sinopsis" rows="3"></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Review-->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reviewModalLabel">Tambah Review</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="tambah-review.php" method="post">
              <div class="form-group">
                <label for="nama">Nama Penulis Review</label>
                <input type="text" class="form-control" name="nama" id="nama" required placeholder="Nama Lengkap">
              </div>
              <div class="form-group">
                <label for="judul_buku">Judul Buku</label>
                <select class="form-control nice-select" name="judul_buku" id="judul_buku" required>
                  <option value="">Pilih Buku</option>
                  <?php
                    if ($resultBuku->num_rows > 0) {
                      while($rowBuku = $resultBuku->fetch_assoc()) {
                        echo '<option value="'.$rowBuku["judul"].'">'.$rowBuku["judul"].'</option>';
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="review">Review</label>
                <textarea class="form-control" name="review" required id="review" rows="3"></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Hero Section Begin -->
    <section class="hero spad set-bg" data-setbg="img/hero.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero__text">
                        <h5>Gudang Buku</h5>
                        <h2>Referensi mencari buku terpercaya.</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Home Room Section Begin -->
    <section class="home-room spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h5>Buku</h5>
                        <h2>List Buku Terbaru</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
          <?php  
          if ($resultBukuLagi->num_rows > 0) {
            while($rowBukuLagi = $resultBukuLagi->fetch_assoc()) {
          ?>
                <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                    <div class="home__room__item set-bg" data-setbg="<?php echo $rowBukuLagi['sampul'] ?>">
                        <div class="home__room__title">
                            <h4><?php echo $rowBukuLagi['judul'] ?></h4>
                            <h2><sup><?php echo $rowBukuLagi['kategori'] ?></sup></h2>
                        </div>
                        <a href="#" data-toggle="modal" data-target="#sinopsisModal<?php echo $rowBukuLagi['id'] ?>">Lihat Sinopsis</a>
                    </div>
                </div>
                <!-- Modal -->
          <div class="modal fade" id="editModal<?php echo $rowBukuLagi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModal<?php echo $rowBukuLagi['id'] ?>Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModal<?php echo $rowBukuLagi['id'] ?>Label">Edit Buku <?php echo $rowBukuLagi["judul"] ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form action="edit-buku.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $rowBukuLagi['id'] ?>">
              <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $rowBukuLagi['judul'] ?>" required placeholder="Judul Buku">
              </div>
              <div class="form-group">
                <label for="kategori">Kategori Buku</label>
                <select class="form-control" name="kategori" id="kategori" required>
                  <option value="">Pilih Kategori</option>
                  <option value="Fiksi" <?php echo $rowBukuLagi['kategori'] == "Fiksi" ? 'selected' : '' ?>>Fiksi</option>
                  <option value="Non Fiksi" <?php echo $rowBukuLagi['kategori'] == "Non Fiksi" ? 'selected' : '' ?>>Non Fiksi</option>
                </select>
              </div>
              <div class="form-group">
                <label for="sampul">Sampul</label>
                <input type="file" class="form-control-file" name="sampul" id="sampul" placeholder="Sampul Buku"  accept="image/*">
                <small id="fileHelpId" class="form-text text-muted">Maximal 1 MB aja yah</small>
              </div>
              <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea class="form-control" name="sinopsis" required id="sinopsis" rows="3"><?php echo $rowBukuLagi['sinopsi'] ?></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="sinopsisModal<?php echo $rowBukuLagi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="sinopsisModal<?php echo $rowBukuLagi['id'] ?>Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="sinopsisModal<?php echo $rowBukuLagi['id'] ?>Label">Sinopsis <?php echo $rowBukuLagi["judul"] ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>
                  <?php echo $rowBukuLagi["sinopsi"] ?>
                  </p>
                </div>
                <div class="modal-footer">

                <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#editModal<?php echo $rowBukuLagi['id'] ?>" class="ml-2 text-white btn btn-warning">Edit</a><a href="hapus-buku.php?id=<?php echo $rowBukuLagi['id'] ?>" class="ml-2 text-white btn btn-danger">Hapus</a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <?php
            }
          }
          ?>
            </div>
        </div>
        <div class="container">
            <div class="home__explore">
                <div class="row">
                    <div class="col-lg-9 col-md-8">
                        <h3>Bantu kami dengan mengupdate katalog buku!</h3>
                    </div>
                    <div class="col-lg-3 col-md-4 text-center">
                        <a href="#" data-toggle="modal" data-target="#bukuModal" class="primary-btn">Klik Disini</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="testimonial__pic">
                        <img src="img/testimonial-left.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="testimonial__text">
                        <div class="section-title">
                            <h5>Review</h5>
                            <h2>Apa tanggapan pembaca terhadap buku ini?</h2>
                        </div>
                        <div class="testimonial__slider__content">
                            <div class="testimonial__slider owl-carousel">
                                <?php if ($resultReview->num_rows > 0) {
                                while($rowReview = $resultReview->fetch_assoc()) { ?>
                                <div class="testimonial__item">
                                    <h5>Review Pembaca:</h5>
                                    <p><?php echo $rowReview['review'] ?>.</p>
                                    <div class="testimonial__author">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="testimonial__author__title">
                                                    <h5><?php echo $rowReview['nama'] ?></h5>
                                                    <span>Judul Buku : <?php echo $rowReview['judul'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                    }
                                ?>
                            </div>
                            <div class="slide-num" id="snh-1"></div>
                            <div class="slider__progress"><span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>