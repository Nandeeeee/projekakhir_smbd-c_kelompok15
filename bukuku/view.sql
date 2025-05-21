CREATE VIEW view_detailtransaksi AS
SELECT 
    b.*,
    dp.IDDetailPenjualan, dp.Jumlah, dp.SubTotal, dp.StatusTransaksi,
    j.IDPenjualan, j.TanggalPenjualan, j.TotalHarga, j.StatusPembayaran,
    pl.*,
    pg.*                                           
FROM detail_penjualan dp
JOIN buku b ON b.KodeBuku = dp.KodeBuku
JOIN penjualan j ON j.IDPenjualan = dp.IDPenjualan 
JOIN pelanggan pl ON j.IDPelanggan = pl.IDPelanggan 
LEFT JOIN pegawai pg ON j.IDPegawai = pg.IDPegawai

--2
CREATE VIEW view_jumlahbukuterjual AS
SELECT 
    b.KodeBuku,
    b.Judul,
    sum(dp.Jumlah) AS TotalTerjual 
FROM detail_penjualan dp 
JOIN buku b ON dp.KodeBuku = b.KodeBuku 
GROUP BY b.Judul

--3
CREATE VIEW View_TotalPenjualanPerHari AS
SELECT
TanggalPenjualan,
COUNT(*) AS JumlahTransaksi,
SUM(TotalHarga) AS TotalPendapatan
FROM Penjualan
GROUP BY TanggalPenjualan;

--4
CREATE VIEW View_PelangganTerbaik AS
SELECT
pl.IDPelanggan,
pl.NamaPelanggan,
SUM(p.TotalHarga) AS TotalBelanja,
COUNT(p.IDPenjualan) AS JumlahTransaksi
FROM Pelanggan pl
JOIN Penjualan p ON pl.IDPelanggan = p.IDPelanggan
GROUP BY pl.IDPelanggan
ORDER BY TotalBelanja DESC;

--5
CREATE VIEW View_BukuHabisStok AS
SELECT * FROM Buku
WHERE Stok <= 3;

