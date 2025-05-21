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
        $gambar = "";
        if(!empty($_FILES['gambar']['name'])) {
            $rand = rand();
            $filename = $_FILES['gambar']['name'];
            $gambar = 'img/'.$rand.'_'.$filename;
        } else {
            $gambar = "";
        }
        move_uploaded_file($_FILES['gambar']['tmp_name'], './../'.$gambar);
        $query = mysqli_query($koneksi, "INSERT INTO buku VALUES ('$kodeBuku', '$judul', '$pengarang', '$penerbit', '$tahun', '$harga', '$stok', '$keterangan', '$gambar')");
        if ($query) {
            echo 
            "<script>alert('Success');</script>";
        }
    }
    if (isset($_POST['updateBuku'])) {
        $kodeBuku = $_POST['updateBuku'];
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];
        $tahun = $_POST['tahun'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $keterangan = $_POST['keterangan'];

        $gambar_old = $_POST['gambar_old'];
        $gambar = "";
        if(!empty($_FILES['gambar']['name'])) {
            $rand = rand();
            $filename = $_FILES['gambar']['name'];
            $gambar = 'img/'.$rand.'_'.$filename;
            move_uploaded_file($_FILES['gambar']['tmp_name'], './../'.$gambar);
        } else {
            $gambar = $gambar_old;
        }
        $query = mysqli_query($koneksi, "CALL SP_UpdateBuku('$judul','$pengarang','$penerbit','$tahun','$harga','$stok','$keterangan','$gambar','$kodeBuku')");
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

    $getAllBuku = null;
    if (isset($_POST['cariin'])) {
        $cari = $_POST['cari'];

        $getAllBuku = mysqli_query($koneksi, "CALL SP_CariBuku('$cari')");
    }
?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Buku</h3>
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
                    <a href="data-buku">Data Buku</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Data Buku</h4>
                        <form class="d-none d-sm-inline-block form-inline navbar-search" style="width: 500px;" action="" method="post">
                            <div class="input-group">
                                <input name="cari" type="text" class="form-control bg-light border-2 border-primary small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button name="cariin" class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Buku</th>
                                        <th>Judul</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Terbit</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (!isset($_POST['cariin'])) {
                                            $getAllBuku = mysqli_query($koneksi, "SELECT * FROM buku");
                                        }
                                        foreach ($getAllBuku as $key => $b) { 
                                    ?>
                                        <tr>
                                            <td><?= $b['KodeBuku']; ?></td>
                                            <td><?= $b['Judul']; ?></td>
                                            <td><?= $b['Pengarang']; ?></td>
                                            <td><?= $b['Penerbit']; ?></td>
                                            <td><?= $b['TahunTerbit']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $b['KodeBuku']; ?>"><i class="fas fa-info"></i></button>
                                                <button type="button" class="btn btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $b['KodeBuku']; ?>"><i class="fas fa-pen"></i></button>
                                                <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $b['KodeBuku']; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="modalDetail<?= $b['KodeBuku']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="./../<?= $b['gambar']; ?>" alt="<?= $b['gambar']; ?>" width="300">
                                                        <p>KodeBuku: <?= $b['KodeBuku']; ?></p>
                                                        <p>Judul: <?= $b['Judul']; ?></p>
                                                        <p>Pengarang: <?= $b['Pengarang']; ?></p>
                                                        <p>Penerbit: <?= $b['Penerbit']; ?></p>
                                                        <p>TahunTerbit: <?= $b['TahunTerbit']; ?></p>
                                                        <p>Harga: <?= $b['Harga']; ?></p>
                                                        <p>Stok: <?= $b['Stok']; ?></p>
                                                        <p>Keterangan: <?= $b['Keterangan']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEdit<?= $b['KodeBuku']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                    </div>
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <img src="./../<?= $b['gambar']; ?>" alt="<?= $b['gambar']; ?>" width="300">
                                                            <input type="hidden" name="gambar_old" value="<?= $b['gambar']; ?>">
                                                            <div class="mb-3">
                                                                <label for="gambar" class="form-label">Gambar</label>
                                                                <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="judul" class="form-label">Judul</label>
                                                                <input value="<?= $b['Judul']?>" type="text" class="form-control" name="judul" id="judul" placeholder="judul" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="pengarang" class="form-label">Pengarang</label>
                                                                <input value="<?= $b['Pengarang']?>" type="text" class="form-control" name="pengarang" id="pengarang" placeholder="pengarang" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="penerbit" class="form-label">Penerbit</label>
                                                                <input value="<?= $b['Penerbit']?>" type="text" class="form-control" name="penerbit" id="penerbit" placeholder="penerbit" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tahun" class="form-label">Tahun Terbit</label>
                                                                <input value="<?= $b['TahunTerbit']?>" type="text" class="form-control" name="tahun" id="tahun" placeholder="tahun" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="harga" class="form-label">Harga</label>
                                                                <input value="<?= $b['Harga']?>" type="text" class="form-control" name="harga" id="harga" placeholder="harga" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stok" class="form-label">Stok</label>
                                                                <input value="<?= $b['Stok']?>" type="text" class="form-control" name="stok" id="stok" placeholder="stok" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <input value="<?= $b['Keterangan']?>" type="text" class="form-control" name="keterangan" id="keterangan" placeholder="keterangan" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary" value="<?= $b['KodeBuku']?>" type="submit" name="updateBuku">Edit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="modalHapus<?= $b['KodeBuku']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <button class="btn btn-primary" value="<?= $b['KodeBuku']?>" type="submit" name="deleteBuku">Hapus</button>
                                                        </div>
                                                    </form>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar" required>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" placeholder="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" name="pengarang" id="pengarang" placeholder="pengarang" required>
                    </div>
                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" name="penerbit" id="penerbit" placeholder="penerbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun Terbit</label>
                        <input type="text" class="form-control" name="tahun" id="tahun" placeholder="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="text" class="form-control" name="stok" id="stok" placeholder="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" name="addBuku">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>