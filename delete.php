<?php
// Cek apakah ada parameter kecamatan
if (isset($_GET['kecamatan'])) {
    $kecamatan = $_GET['kecamatan'];

    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "penduduk_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hapus data berdasarkan kecamatan
    $sql = "DELETE FROM penduduk WHERE kecamatan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kecamatan);

    if ($stmt->execute()) {
        // Jika sukses, arahkan ke index.php dengan pesan sukses
        header("Location: index.php?message=Record deleted successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
