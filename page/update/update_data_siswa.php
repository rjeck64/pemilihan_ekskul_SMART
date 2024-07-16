<?php
// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
include "../../koneksi.php";
// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dapatkan data dari form
    $kd_siswa = $_POST['kd_siswa'];
    $nm_siswa = $_POST['nm_siswa'];
    $minat = $_POST['minat'];
    $pengalaman = $_POST['pengalaman'];
    $teknikal = $_POST['teknikal'];
    $fisik = $_POST['fisik'];
    $komunikasi = $_POST['komunikasi'];
    $kerjasama_tim = $_POST['kerjasama_tim'];

    // Query untuk memperbarui data siswa
    $sql = "UPDATE siswa SET 
            nm_siswa = ?, 
            minat = ?, 
            pengalaman = ?, 
            teknikal = ?, 
            fisik = ?, 
            komunikasi = ?,
            kerjasama_tim = ? 
            WHERE kd_siswa = ?";

    // Siapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter ke statement
        $stmt->bind_param("sssssssi", $nm_siswa, $minat, $pengalaman, $teknikal, $fisik, $komunikasi, $kerjasama_tim, $kd_siswa);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, kirim respons sukses
            echo "Data updated successfully!";
        } else {
            // Jika gagal, kirim respons error
            echo "Error updating record: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Jika gagal menyiapkan statement, kirim respons error
        echo "Error preparing statement: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
} else {
    // Jika metode bukan POST, kirim respons error
    echo "Invalid request method.";
}
?>
