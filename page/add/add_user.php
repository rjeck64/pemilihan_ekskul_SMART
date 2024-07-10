<?php
// Include koneksi database Anda
include '../../koneksi.php';

// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dapatkan data dari form POST
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Hash password
    $level = $_POST['level'];

    // Query untuk menambahkan data user baru
    $sql = "INSERT INTO user (username, email, password, level) VALUES (?, ?, ?, ?)";

    // Siapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter ke statement
        $stmt->bind_param("ssss", $username, $email, $password, $level);

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
