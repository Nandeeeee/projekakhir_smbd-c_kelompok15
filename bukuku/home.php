<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>Semua</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php 
                            $getAllBuku = mysqli_query($koneksi, "SELECT * FROM buku");
                            foreach ($getAllBuku as $key => $b) { 
                        ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg=<?= $b['gambar']; ?>>
                                    </div>
                                    <div class="product__item__text">
                                        <h5><a href="buku-detail?id=<?= $b['KodeBuku']; ?>"><?= $b['Judul']; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="product__sidebar">
                    <div class="product__sidebar__view">
                        <div class="section-title">
                            <h5>Terlaris</h5>
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