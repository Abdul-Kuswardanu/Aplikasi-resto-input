<?php
require_once 'config.php';
require_once 'db_install_db.php';
require_once 'function.php'; 

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
    <title>Tambah Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            background-color: #1b99b5;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #169fa2;
        }

        .dashboard h1 {
            margin: 0;
            font-size: 24px;
        }

        .dashboard a {
            color: white;
            text-decoration: none;
            padding: 10px;
            background-color: #fff;
            color: #1b99b5;
            border-radius: 5px;
            font-weight: bold;
        }

        .dashboard a:hover {
            background-color: #169fa2;
            color: white;
        }

        .form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form input[type="text"], 
        .form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form input[type="submit"] {
            padding: 10px 20px;
            background-color: #1b99b5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form input[type="submit"]:hover {
            background-color: #169fa2;
        }

        @media (max-width: 600px) {
            .dashboard h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h1>Tambah Data Menu</h1>
    <div>
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome, <?php echo $_SESSION['username']; ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="form">
    <?php 
    addData(); 
    ?>
</div>

</body>
</html>
