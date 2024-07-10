<?php
// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
include "../../koneksi.php";

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['id_siswa'])) {
    $idSiswa = $_POST['id_siswa'];

    // Query untuk mengambil data siswa berdasarkan ID
    $sql = "SELECT * FROM siswa WHERE kd_siswa = $idSiswa";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(array()); // Kirim array kosong jika tidak ada data
    }
}

$conn->close();
?>
