<?php
require_once 'config.php';
require_once 'db_install_db.php';
require_once 'function.php'; 

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    deleteData($db, $id);
    header("Location: index.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    deleteData($db, $id);

    $resetAutoIncrementSQL = "ALTER TABLE menu AUTO_INCREMENT = 1";
    $db->query($resetAutoIncrementSQL);

    header("Location: index.php");
    exit;
}


$result = getDataFromTable($db, "menu"); 

session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="table.css">
    <title>Data Tabel</title>
</head>
<body>
<div class="dashboard">
    <h1>Menu Order</h1>
    <div>
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome, <?php echo $_SESSION['username']; ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</div>
<div style="text-align: center; margin: 20px;">
    <button class="button" onclick="window.location.href='tambah_data.php'">Tambah Data</button>
</div>
<center><h2>Data Menu</h2></center>
<table>
    <tr>
        <th>No</th>
        <th>Foto Menu</th>
        <th>Menu</th>
        <th>Harga</th>
        <th>Dibuat Tanggal</th>
        <th>Update Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php
    displayTableData($result);
    ?>
</table>
</body>
</html>
