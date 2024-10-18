<?php
require_once 'config.php';
require_once 'db_install_db.php';
require_once 'function.php';

session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = getDataFromTable($db, "menu");
    $row = null;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["id"] == $id) {
                break;
            }
        }
    }
    
    if (!$row) {
        die("Data tidak ditemukan.");
    }
} else {
    die("ID tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu = $_POST['menu'];
    $harga = $_POST['harga'];
    $foto_menu = $_FILES["foto_menu"]["name"];
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto_menu);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (!empty($foto_menu)) {
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["foto_menu"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File yang diunggah bukan gambar.";
                $uploadOk = 0;
            }
        }

        if (file_exists($target_file)) {
            echo "Maaf, file sudah ada.";
            $uploadOk = 0;
        }

        if ($_FILES["foto_menu"]["size"] > 500000) {
            echo "Maaf, ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Maaf, hanya file gambar JPG, JPEG, PNG & GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Maaf, file Anda tidak dapat diunggah.";
        } else {
            if (move_uploaded_file($_FILES["foto_menu"]["tmp_name"], $target_file)) {
                echo "File ". basename($_FILES["foto_menu"]["name"]). " berhasil diunggah.";
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    }
    
    $foto_menu = empty($foto_menu) ? $row['foto_menu'] : basename($_FILES["foto_menu"]["name"]);
    
    $sql = "UPDATE menu SET foto_menu = '$foto_menu', menu = '$menu', harga = '$harga' WHERE id = $id";
    
    if ($db->query($sql) === TRUE) {
        echo "Data berhasil diperbarui!";
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            background-color: #1b99b5;
            color: white;
            text-align: center;
            padding: 20px;
        }

        h1 {
            margin: 0;
        }

        .form {
            width: 40%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form input[type="submit"] {
            background-color: #1b99b5;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px 0;
        }

        .form input[type="submit"]:hover {
            background-color: #157a92;
        }

        .form label {
            display: block;
            margin: 5px 0;
            font-weight: bold;
        }

        .form a {
            color: #1b99b5;
            text-decoration: none;
        }

        .form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h1>Edit Data Menu</h1>
</div>

<div class="form">
    <form action="edit_data.php?id=<?php echo $row['id']; ?>" method="post" enctype="multipart/form-data">
        <label>Nama Menu:</label>
        <input type="text" name="menu" value="<?php echo $row['menu']; ?>" required><br>
        
        <label>Harga:</label>
        <input type="text" name="harga" value="<?php echo $row['harga']; ?>" required><br>
        
        <label>Foto Menu:</label>
        <input type="file" name="foto_menu" accept="upload/*"><br>
        
        <input type="submit" value="Perbarui Data" name="submit" class="button">
    </form>
</div>

</body>
</html>
