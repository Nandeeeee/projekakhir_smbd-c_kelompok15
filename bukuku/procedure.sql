DELIMITER //

CREATE PROCEDURE SP_CariBuku(IN keyword VARCHAR(100))
BEGIN
SELECT * FROM Buku
WHERE 
Judul LIKE CONCAT('%', keyword, '%') OR
Pengarang LIKE CONCAT('%', keyword, '%') OR
Penerbit LIKE CONCAT('%', keyword, '%') OR
TahunTerbit LIKE CONCAT('%', keyword, '%') OR
Harga LIKE CONCAT('%', keyword, '%') OR
Stok LIKE CONCAT('%', keyword, '%') OR
Keterangan LIKE CONCAT('%', keyword, '%');
END //

DELIMITER ;

--2
DELIMITER //

CREATE PROCEDURE SP_TambahPelanggan(
IN p_nama VARCHAR(100),
IN p_alamat TEXT,
IN p_nohp VARCHAR(15),
IN p_email VARCHAR(200),
IN p_password VARCHAR(200)
)
BEGIN
INSERT INTO Pelanggan (NamaPelanggan, Alamat, NoHP, email, password)
VALUES (p_nama, p_alamat, p_nohp, p_email, p_password);
END//

DELIMITER;

--3
DELIMITER //
CREATE PROCEDURE SP_LihatTransaksiPelanggan(IN p_id INT)
BEGIN
SELECT * FROM View_DetailTransaksi WHERE IDPelanggan = p_id;
END //
DELIMITER ;

--4
DELIMITER //
CREATE PROCEDURE SP_UpdateBuku(
    IN p_judul VARCHAR(100),
    IN p_pengaran VARCHAR(100),
    IN p_penerbit VARCHAR(100),
    IN p_tahun YEAR,
    IN p_harga INT,
    IN p_stok INT,
    IN p_keterangan VARCHAR(100),
    IN p_gambar VARCHAR(100),
    IN p_kode VARCHAR(100)
)
BEGIN
    UPDATE buku SET 
    Judul = p_judul,
    Pengarang = p_pengaran,
    Penerbit = p_penerbit,
    TahunTerbit = p_tahun,
    Harga = p_harga,
    Stok = p_stok,
    Keterangan =  p_keterangan,
    gambar = p_gambar
    WHERE KodeBuku = p_kode;
END //
DELIMITER ;

--5
DELIMITER //

CREATE PROCEDURE GetTotalPendapatanPerPeriode(
IN tanggal_awal DATE,
IN tanggal_akhir DATE,
)
BEGIN
SELECT 
SUM(TotalHarga) as Total
FROM Penjualan
WHERE TanggalPenjualan BETWEEN tanggal_awal AND tanggal_akhir;
END //

DELIMITER ;
