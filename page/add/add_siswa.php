<?php
// Include koneksi database Anda
include '../../koneksi.php';
// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dapatkan data dari form
    $nm_siswa = $_POST['nm_siswa'];
    $minat = $_POST['minat'];
    $pengalaman = $_POST['pengalaman'];
    $teknikal = $_POST['teknikal'];
    $fisik = $_POST['fisik'];
    $komunikasi = $_POST['komunikasi'];
    $kerjasama_tim = $_POST['kerjasama_tim'];

    // Query untuk menambahkan data siswa
    $sql = "INSERT INTO siswa (nm_siswa, minat, pengalaman, teknikal, fisik, komunikasi, kerjasama_tim) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Siapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter ke statement
        $stmt->bind_param("sssssss", $nm_siswa, $minat, $pengalaman, $teknikal, $fisik, $komunikasi, $kerjasama_tim);

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
