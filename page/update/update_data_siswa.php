<?php
// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
include "../../koneksi.php";
// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dapatkan data dari form
    $kd_siswa = $_POST['kd_siswa'];
    $nm_siswa = $_POST['nm_siswa'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $kelas = $_POST['kelas'];

    // Query untuk memperbarui data siswa
    $sql = "UPDATE siswa SET 
            nm_siswa = ?, 
            alamat = ?, 
            no_telepon = ?, 
            jenis_kelamin = ?, 
            tanggal_lahir = ?, 
            kelas = ? 
            WHERE kd_siswa = ?";

    // Siapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter ke statement
        $stmt->bind_param("ssssssi", $nm_siswa, $alamat, $no_telepon, $jenis_kelamin, $tanggal_lahir, $kelas, $kd_siswa);

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
