<?php
require_once "config.php";

$db = new mysqli(HOSTNAME, USERNAME, PASSWORD);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

$sql_buat_db = "CREATE DATABASE IF NOT EXISTS " . DATABASE;
$eksekusi_buat_db = $db->query($sql_buat_db);

if ($eksekusi_buat_db) {
    // echo 'Buat database berhasil' . '<br>';
} else {
    echo 'Gagal membuat database: ' . $db->error . '<br>';
}

$db->select_db(DATABASE);

if ($db->error) {
    die("Gagal menggunakan database: " . $db->error);
}

$sql_masuk_db = "USE kasir";
$eksekusi_masuk_db = $db->query($sql_masuk_db);

if ($eksekusi_masuk_db) {
    // echo 'Sudah masuk ke database' . '<br>';
} else {
    echo 'Gagal masuk ke database: ' . $db->error . '<br>';
}

$db->select_db(DATABASE);

if ($db->error) {
    die("Gagal menggunakan database: " . $db->error);
}

$sql = "CREATE TABLE IF NOT EXISTS menu (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    foto_menu VARCHAR(255) NOT NULL,
    menu VARCHAR(50) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($db->query($sql) === TRUE) {
    // echo "Tabel Menu berhasil dibuat";
} else {
    echo "Error membuat tabel: " . $db->error;
}

$resetAutoIncrementSQL = "ALTER TABLE menu AUTO_INCREMENT = 1";
$db->query($resetAutoIncrementSQL);

// if ($resetAutoIncrementSQL) {
//     echo 'berhasil reset' . '<br>';
// } else {
//     echo 'Gagal reset ' . $db->error . '<br>';
// }


// $db->close();
?>
