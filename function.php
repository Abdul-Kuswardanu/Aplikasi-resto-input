<?php
/** ----------------------------------------------------- */
// Fungsi untuk mengambil data dari tabel
function getDataFromTable($db, $table) {
    $sql = "SELECT * FROM $table ORDER BY id ASC";
    return $db->query($sql);
    if (!$result) {
        // Jika query gagal, tampilkan pesan error
        die("Error: " . $db->error);
    }
    return $result;
}


/** ----------------------------------------------------- */


/** ----------------------------------------------------- */


// Fungsi untuk menampilkan data tabel dalam HTML
function displayTableData($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $foto_menu = !empty($row["foto_menu"]) ? "<img src='uploads/" . $row["foto_menu"] . "' alt='" . $row["menu"] . "'>" : "-";
            
            $harga = number_format($row["harga"], 2, ',', '.');
            $formatted_harga = "IDR " . $harga;

            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $foto_menu . "</td>
                    <td>" . $row["menu"] . "</td>
                    <td>" . $formatted_harga . "</td>
                    <td>" . $row["created_at"] . "</td>
                    <td>" . $row["updated_at"] . "</td>
                    <td>
                        <a href='edit_data.php?id=" . $row["id"] . "' class='button-edit'>Edit</a>
                        <a href='index.php?action=delete&id=" . $row["id"] . "' class='button-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
    }
}

/** ----------------------------------------------------- */

// Fungsi untuk memulai session dan mengecek apakah user sudah login
function checkLogin() {
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
}

/** ----------------------------------------------------- */

// Fungsi untuk login
function loginUser($db, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    return false;
}

/** ----------------------------------------------------- */

// Fungsi untuk logout
function logout() {
    session_start();
    session_unset();
    session_destroy();
}

/** ----------------------------------------------------- */

// Fungsi untuk menampilkan tombol edit dan hapus
function displayActions($id) {
    echo "<td>
            <a href='edit_data.php?id=$id' class='button'>Edit</a>
            <a href='delete_data.php?id=$id' class='button'>Hapus</a>
          </td>";
}

/** ----------------------------------------------------- */

// Fungsi untuk menambah data (termasuk upload foto)
function addData() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $menu = $_POST['menu'];
        $harga = $_POST['harga'];
        
        $foto_menu = null; 

        if (!empty($_FILES["foto_menu"]["name"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["foto_menu"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["foto_menu"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File yang diunggah bukan gambar.";
                $uploadOk = 0;
            }

            if (file_exists($target_file)) {
                echo "Maaf, file sudah ada.";
                $uploadOk = 0;
            }

            if ($_FILES["foto_menu"]["size"] > 500000) {
                echo "Maaf, ukuran file terlalu besar.";
                $uploadOk = 0;
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                echo "Maaf, hanya file gambar JPG, JPEG, PNG & GIF yang diperbolehkan.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Maaf, file Anda tidak dapat diunggah.";
            } else {
                if (move_uploaded_file($_FILES["foto_menu"]["tmp_name"], $target_file)) {
                    echo "File ". basename($_FILES["foto_menu"]["name"]). " berhasil diunggah.";
                    $foto_menu = basename($_FILES["foto_menu"]["name"]);
                } else {
                    echo "Maaf, terjadi kesalahan saat mengunggah file.";
                }
            }
        }

        global $db;
        
        if ($foto_menu) {
            $sql = "INSERT INTO menu (foto_menu, menu, harga) VALUES ('$foto_menu', '$menu', '$harga')";
        } else {
            $sql = "INSERT INTO menu (menu, harga) VALUES ('$menu', '$harga')";
        }

        if ($db->query($sql) === TRUE) {
            echo "<p>Data berhasil ditambahkan!</p>";
            echo "<a href='index.php' class='button-back'>Kembali ke Halaman Utama</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "<form action='tambah_data.php' method='post' enctype='multipart/form-data'>
                <label>Nama Menu:</label>
                <input type='text' name='menu' required><br>
                
                <label>Harga:</label>
                <input type='text' name='harga' required><br>
                
                <label>Foto Menu (Opsional):</label>
                <input type='file' name='foto_menu' accept='image/*'><br>
                
                <input type='submit' value='Tambah Data' name='submit'>
              </form>";
    }
}

/** ----------------------------------------------------- */

// Fungsi untuk mengedit data
function editData($db, $id, $newValue) {
    $sql = "UPDATE menu SET value = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $newValue, $id);
    $stmt->execute();
}

/** ----------------------------------------------------- */

// Fungsi untuk menghapus data
function deleteData($db, $id) {
    $sql = "DELETE FROM menu WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $resetAutoIncrementSQL = "ALTER TABLE menu AUTO_INCREMENT = 1";
    $db->query($resetAutoIncrementSQL);
}


/** ----------------------------------------------------- */

?>
