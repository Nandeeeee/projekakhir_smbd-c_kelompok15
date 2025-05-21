<?php 
    if (!isset($_SESSION['userLogin'])) {
        header('Location: login.php');
    }
    
    $getid = $_GET['id'];
    $getBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE KodeBuku = '$getid'");
    $data = mysqli_fetch_array($getBuku);

    if (isset($_POST['beliBuku'])) {
        $jumlah = $_POST['jumlah'];

        $harga = $_POST['harga'];
        $tanggal = date('Y-m-d');

        $total = $harga * $jumlah;

        $idPelanggan = $_SESSION['userLogin']['IDPelanggan'];
        $queryPenjualan = mysqli_query($koneksi, "INSERT INTO penjualan VALUES ('', '$tanggal', '$idPelanggan', null, '$total', 'Lunas')");
        if ($queryPenjualan) {
            $idtadi = mysqli_insert_id($koneksi);
            $queryDetail = mysqli_query($koneksi, "INSERT INTO detail_penjualan VALUES ('', '$idtadi', '$getid', '$jumlah', '$total', '')");
            if ($queryDetail) {
                echo 
                "
                <script>
                    alert('Success \n
                        Total harga: '$total'
                    ');
                </script>
                ";
            }
        }
    }
?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="home"><i class="fa fa-home"></i> Home</a>
                    <a href="buku-detail?id=<?= $data['KodeBuku']; ?>"> <?= $data['Judul']; ?></a>
                    <span>Beli</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6">
            <div class="login__form">
                <h3>Form</h3>
                <form action="" method="post">
                    <div class="input__item">
                        <input name="jumlah" type="text" placeholder="Jumlah Buku" required>
                        <span><i class="fa-solid fa-book"></i></span>
                    </div>
                    <input type="hidden" name="harga" value="<?= $data['Harga']; ?>">
                    <button name="beliBuku" type="submit" class="site-btn">Beli</button>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="anime__details__pic set-bg" data-setbg="img/anime/details-pic.jpg">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="anime__details__text">
                        <div class="anime__details__title">
                            <h3><?= $data['Judul']; ?></h3>
                            <span><?= $data['TahunTerbit']; ?></span>
                        </div>
                        <p><?= $data['Keterangan']; ?></p>
                        <div class="anime__details__widget">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <ul>
                                        <li><span>Pengarang</span> <?= $data['Pengarang']; ?></li>
                                        <li><span>Penerbit</span> <?= $data['Penerbit']; ?></li>
                                        <li><span>Harga</span> <?= $data['Harga']; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>