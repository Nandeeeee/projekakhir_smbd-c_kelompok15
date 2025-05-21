<div class="container">
    <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-12">
                <h4 class="fw-bold mb-3">Pendapatan PerPeriode</h4>
                <form action="" method="post" class="d-flex align-items-left align-items-md-center">
                    <label for="tglAwal" class="me-5 form-label">Awal</label>
                    <input type="date" class="form-control" name="tglAwal" id="tglAwal" required>
                    <label for="tglAkhir" class="ms-5 me-5 form-label">Akhir</label>
                    <input type="date" class="form-control" name="tglAkhir" id="tglAkhir" required>
                    <button class="btn btn-primary ms-5" type="submit" name="cari">Simpan</button>
                </form>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><center>Total</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (isset($_POST['cari'])) {
                                $tglAwal = $_POST['tglAwal'];
                                $tglAkhir = $_POST['tglAkhir'];
                                $query = mysqli_query($koneksi, "CALL GetTotalPendapatanPerPeriode('$tglAwal', '$tglAkhir')");
                                $data = mysqli_fetch_array($query);
                                mysqli_free_result($query);
                                mysqli_next_result($koneksi);
                        ?>
                        <tr>
                            <td><center><?= $data['Total']; ?></center></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td><center>Tidak ada</center></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <h4 class="fw-bold mb-3">Rekap Penjualan Perhari</h4>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $getAllBuku = mysqli_query($koneksi, "SELECT * FROM View_TotalPenjualanPerHari");
                            foreach ($getAllBuku as $key => $dp) { 
                        ?>
                            <tr>
                                <td><?= $key+1; ?></td>
                                <td><?= $dp['TanggalPenjualan']; ?></td>
                                <td><?= $dp['JumlahTransaksi']; ?></td>
                                <td><?= $dp['TotalPendapatan']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <h4 class="fw-bold mb-3">Pelanggan Terbaik</h4>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Belanja</th>
                            <th>Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $getAllBuku = mysqli_query($koneksi, "SELECT * FROM View_PelangganTerbaik");
                            foreach ($getAllBuku as $key => $dp) { 
                        ?>
                            <tr>
                                <td><?= $key+1; ?></td>
                                <td><?= $dp['NamaPelanggan']; ?></td>
                                <td><?= $dp['TotalBelanja']; ?></td>
                                <td><?= $dp['JumlahTransaksi']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h4 class="fw-bold mb-3">Stok Buku Hampir Habis</h4>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $getAllBuku = mysqli_query($koneksi, "SELECT * FROM View_BukuHabisStok");
                            if (mysqli_num_rows($getAllBuku)) {
                            foreach ($getAllBuku as $key => $dp) { 
                        ?>
                            <tr>
                                <td><?= $dp['KodeBuku']; ?></td>
                                <td><?= $dp['Judul']; ?></td>
                                <td><?= $dp['Stok']; ?></td>
                            </tr>
                        <?php }} else { ?>
                            <tr>
                                <td colspan="3"><center>Tidak ada</center></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>