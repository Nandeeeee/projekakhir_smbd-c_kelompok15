<?php 
    if (isset($_POST['updatePenjualan'])) {
        $id = $_POST['updatePenjualan'];
        $IDPenjualan = $_POST['IDPenjualan'];
        $Harga = $_POST['Harga'];
        $Jumlah = $_POST['Jumlah'];
        $Total = $Harga * $Jumlah;

        $query = mysqli_query($koneksi, "UPDATE detail_penjualan SET Jumlah = $Jumlah WHERE IDDetailPenjualan = $id");
        $query = mysqli_query($koneksi, "UPDATE penjualan SET TotalHarga = $Total WHERE IDPenjualan = $IDPenjualan");
    }
    if (isset($_POST['deletePenjualan'])) {
        $id = $_POST['deletePenjualan'];

        $query = mysqli_query($koneksi, "DELETE FROM detail_penjualan WHERE IDPenjualan = $id");
        $query = mysqli_query($koneksi, "DELETE FROM penjualan WHERE IDPenjualan = $id");
    }
?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="home"><i class="fa fa-home"></i> Beranda</a>
                    <span>Riwayat</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<section class="anime-details spad">
    <div class="container">
        <div class="anime__details__content">
            <table class="table table-bordered text-light">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $id = $_SESSION['userLogin']['IDPelanggan'];
                        $query = mysqli_query($koneksi, "CALL SP_LihatTransaksiPelanggan($id)");
                        foreach ($query as $key => $d) {
                    ?>
                    <tr>
                        <td><?= $key+1; ?></td>
                        <td><?= $d['TanggalPenjualan']; ?></td>
                        <td><?= $d['Judul']; ?></td>
                        <td><?= $d['Jumlah']; ?></td>
                        <td><?= $d['TotalHarga']; ?></td>
                        <td><?= $d['StatusPembayaran']; ?></td>
                        <td>
                            <button type="button" class="btn btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['IDDetailPenjualan']; ?>"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $d['IDDetailPenjualan']; ?>"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?= $d['IDDetailPenjualan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                </div>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="Jumlah" class="form-label">Jumlah</label>
                                            <input type="hidden" name="Harga" value="<?= $d['Harga']?>">
                                            <input type="hidden" name="IDPenjualan" value="<?= $d['IDPenjualan']?>">
                                            <input value="<?= $d['Jumlah']?>" type="text" class="form-control" name="Jumlah" id="Jumlah" placeholder="Jumlah" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button value="<?= $d['IDDetailPenjualan']?>" class="btn btn-primary" type="submit" name="updatePenjualan">Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Hapus -->
                    <div class="modal fade" id="modalHapus<?= $d['IDDetailPenjualan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                </div>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <p>Yakin ingin hapus?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" value="<?= $d['IDPenjualan']?>" type="submit" name="deletePenjualan">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>