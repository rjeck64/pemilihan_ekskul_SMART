<?php
// Include koneksi database Anda
include '../../koneksi.php';

// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dapatkan ID user dari data POST
    $id = $_POST['id'];

    // Query untuk menghapus data user berdasarkan ID
    $sql = "DELETE FROM user WHERE id=?";

    // Siapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter ke statement
        $stmt->bind_param("i", $id);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, kirim respons sukses
            echo "Data deleted successfully!";
        } else {
            // Jika gagal, kirim respons error
            echo "Error deleting record: " . $stmt->error;
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
