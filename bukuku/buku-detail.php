<?php
    $getid = $_GET['id'];
    $getBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE KodeBuku = '$getid'");
    $data = mysqli_fetch_array($getBuku);
?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="home"><i class="fa fa-home"></i> Beranda</a>
                    <span><?= $data['Judul']; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<section class="anime-details spad">
    <div class="container">
        <div class="anime__details__content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="anime__details__pic set-bg" data-setbg=<?= $data['gambar']; ?>>
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
                        <div class="anime__details__btn">
                            <a href="beli?id=<?= $data['KodeBuku']; ?>" class="follow-btn"><i class="fa fa-cart-shopping"></i> Beli</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>Rekomendasi</h5>
                        </div>
                        <?php 
                            $getTopBuku = mysqli_query($koneksi, "SELECT * FROM `view_jumlahbukuterjual`");
                            foreach ($getTopBuku as $key => $b) { 
                        ?>
                            <div class="filter__gallery">
                                <div class="product__sidebar__view__item set-bg mix day years"
                                data-setbg=<?= $b['gambar']; ?>>
                                    <h5 class="bg-dark"><a href="buku-detail?id=<?= $b['KodeBuku']; ?>"><?= $b['Judul']; ?>&nbsp;&nbsp;(<?=$b['TotalTerjual']; ?>)</a></h5>
                                </div>
                            </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>