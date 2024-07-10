<?php
// Include koneksi database Anda
include '../../koneksi.php';
// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dapatkan data dari form
    $nm_siswa = $_POST['nm_siswa'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $kelas = $_POST['kelas'];

    // Query untuk menambahkan data siswa
    $sql = "INSERT INTO siswa (nm_siswa, alamat, no_telepon, jenis_kelamin, tanggal_lahir, kelas) VALUES (?, ?, ?, ?, ?, ?)";

    // Siapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter ke statement
        $stmt->bind_param("ssssss", $nm_siswa, $alamat, $no_telepon, $jenis_kelamin, $tanggal_lahir, $kelas);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, kirim respons sukses
            echo "Data added successfully!";
        } else {
            // Jika gagal, kirim respons error
            echo "Error adding record: " . $stmt->error;
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
