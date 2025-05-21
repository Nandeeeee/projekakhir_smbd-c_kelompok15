<?php 
    session_start();
    $koneksi = mysqli_connect("localhost", "root", "", "bukuku");

    if ($koneksi->connect_error) die("Koneksi gagal: " . $koneksi->connect_error);

    function generateKodeBuku() {
        global $koneksi;
        $query = mysqli_query($koneksi, "SELECT KodeBuku FROM buku ORDER BY KodeBuku DESC LIMIT 1");

        if (mysqli_num_rows($query) > 0) {
            $lastId = mysqli_fetch_assoc($query)['KodeBuku'];
            $num = intval(substr($lastId, 2)) + 1;
            $newId = 'BK' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'BK001';
        }

        return $newId;
    }
?>