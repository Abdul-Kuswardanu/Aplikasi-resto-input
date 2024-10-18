<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = $_POST['menu'];
    $harga = $_POST['harga'];

    $foto_menu = $_FILES['foto_menu']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto_menu);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (getimagesize($_FILES['foto_menu']['tmp_name']) === false) {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES['foto_menu']['size'] > 5000000) {
        echo "File terlalu besar.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "File tidak diupload.";
    } else {
        if (move_uploaded_file($_FILES['foto_menu']['tmp_name'], $target_file)) {
            echo "File " . htmlspecialchars(basename($foto_menu)) . " berhasil diupload.";

            $sql = "INSERT INTO menu (menu, harga, foto_menu) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sss", $menu, $harga, $target_file);
            if ($stmt->execute()) {
                echo "Data berhasil ditambahkan.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Ada kesalahan saat mengupload file.";
        }
    }
}
?>
