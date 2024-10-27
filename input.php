<?php
// Cek apakah form dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dengan aman
    $kecamatan = $_POST['kecamatan'] ?? '';
    $luas = $_POST['luas'] ?? 0;
    $jumlah_penduduk = $_POST['jumlah_penduduk'] ?? 0;
    $longitude = $_POST['longitude'] ?? 0;
    $latitude = $_POST['latitude'] ?? 0;

    // Sesuaikan dengan setting MySQL
    $servername = "localhost";
    $username = "root";
    $password = ""; // Ganti jika perlu
    $dbname = "penduduk_db"; // Pastikan nama database benar

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk memasukkan data
    $sql = "INSERT INTO penduduk (kecamatan, luas, jumlah_penduduk, longitude, latitude) 
            VALUES (?, ?, ?, ?, ?)";

    // Siapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdidd", $kecamatan, $luas, $jumlah_penduduk, $longitude, $latitude);

    // Eksekusi query dan cek hasil
    if ($stmt->execute()) {
        // Arahkan ke index.php dengan parameter success
        header("Location: index.php?success=true");
        exit;
    } else {
        // Jika gagal, arahkan ke index.php tanpa parameter
        header("Location: index.php?success=false");
        exit;
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
