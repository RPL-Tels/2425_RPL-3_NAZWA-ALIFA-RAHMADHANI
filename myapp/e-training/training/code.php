<?php
session_start(); // Start session

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "e-training";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menambahkan user baru
// Menambahkan user baru
if (isset($_POST['registerbtn'])) {
    $username = $_POST['username'];
    $id_pegawai = $_POST['id_pegawai']; // Added id_pegawai
    $divisi = $_POST['divisi'];
    $password = $_POST['pass'];
    $cpassword = $_POST['confirmpassword'];

    // Cek apakah username sudah ada
    $username_query = "SELECT * FROM login WHERE username=?";
    $stmt = $conn->prepare($username_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['status'] = "Username Already Taken. Please Try Another one.";
        $_SESSION['status_code'] = "error";
        header('Location: user_acc.php');
        exit(); // Always exit after redirection to prevent further code execution
    } else {
        if ($password === $cpassword) {
            // Insert user baru
            $query = "INSERT INTO login (username, id_pegawai, divisi, pass) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $username, $id_pegawai, $divisi, $password); // Bound id_pegawai

            if ($stmt->execute()) {
                $_SESSION['status'] = "User Added";
                $_SESSION['status_code'] = "success";
                header('Location: user_acc.php');
                exit();
            } else {
                $_SESSION['status'] = "User Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: register.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: user_acc.php');
            exit();
        }
    }
}

// Mengupdate data user berdasarkan id_user
// Mengupdate data user berdasarkan id_user
if (isset($_POST['updatebtn'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $id_pegawai = $_POST['id_pegawai'];
    $divisi = $_POST['divisi'];
    $password = $_POST['pass'];

    // Update query with prepared statement
    $update_query = "UPDATE login SET username=?, id_pegawai=?, divisi=?, pass=? WHERE id_user=?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("ssssi", $username, $id_pegawai, $divisi, $password, $id_user);

    if ($stmt_update->execute()) {
        $_SESSION['status'] = "User Data Updated Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error: " . $stmt_update->error;
        $_SESSION['status_code'] = "error";
    }

    header('Location: user_acc.php');
    exit();
}

$conn->close();
?>
