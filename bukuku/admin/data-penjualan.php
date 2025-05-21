<?php 
    if (isset($_POST['addBuku'])) {
        $kodeBuku = generateKodeBuku();
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];
        $tahun = $_POST['tahun'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $keterangan = $_POST['keterangan'];

        $query = mysqli_query($koneksi, "INSERT INTO buku VALUES ('$kodeBuku', '$judul', '$pengarang', '$penerbit', '$tahun', '$harga', '$stok', '$keterangan')");
        if ($query) {
            echo 
            "<script>alert('Success');</script>";
        }
    }
    if (isset($_POST['updateBuku'])) {
        $kodeBuku = $_POST['id'];
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];
        $tahun = $_POST['tahun'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $keterangan = $_POST['keterangan'];

        $query = mysqli_query($koneksi, "UPDATE buku SET Judul = '$judul', Pengarang = '$pengarang', Penerbit = '$penerbit', TahunTerbit = '$tahun', Harga = '$harga', Stok = '$stok', Keterangan = '$keterangan' WHERE KodeBuku = '$kodeBuku'");
        if ($query) {
            echo 
            "<script>alert('Success');</script>";
        }
    }
    if (isset($_POST['deleteBuku'])) {
        $kodeBuku = $_POST['deleteBuku'];

        $query = mysqli_query($koneksi, "DELETE FROM buku WHERE KodeBuku = '$kodeBuku'");
        if ($query) {
            echo 
            "<script>alert('Success');</script>";
        }
    }
?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Penjualan</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="dashboard">
                    <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="data-buku">Data Penjualan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Data Penjualan</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>Pegawai</th>
                                        <th>Status</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $getAllBuku = mysqli_query($koneksi, "SELECT * FROM View_DetailTransaksi");
                                        foreach ($getAllBuku as $key => $dp) { 
                                    ?>
                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td><?= $dp['TanggalPenjualan']; ?></td>
                                            <td><?= $dp['email']; ?></td>
                                            <td><?= $dp['NamaPegawai']; ?></td>
                                            <td><?= $dp['StatusPembayaran']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $dp['IDPenjualan']; ?>"><i class="fas fa-info"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="modalDetail<?= $dp['IDPenjualan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="fw-bolder">Data Penjualan:</p>
                                                        <p>Tanggal Penjualan: <?= $dp['TanggalPenjualan']; ?></p>
                                                        <p>Total Harga: <?= $dp['TotalHarga']; ?></p>
                                                        <p>KodeBuku: <?= $dp['KodeBuku']; ?></p>
                                                        <p>Jumlah: <?= $dp['Jumlah']; ?></p>
                                                        <p>Nama Pegawai: <?= $dp['NamaPegawai']; ?></p>
                                                        <p class="fw-bolder">Data Pelanggan:</p>
                                                        <p>Nama: <?= $dp['NamaPelanggan']; ?></p>
                                                        <p>Alamat: <?= $dp['Alamat']; ?></p>
                                                        <p>No HP: <?= $dp['NoHP']; ?></p>
                                                        <p>Email: <?= $dp['email']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>