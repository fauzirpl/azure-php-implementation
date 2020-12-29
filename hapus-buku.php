<?php
session_start();
include 'koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // sql to delete a record
    $sql = "DELETE FROM buku WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["sukses"] = TRUE;
    } else {
        $_SESSION["error"] = "Error: ${sql}" . $conn->error;
    }
}

echo "<script> location.href='index.php'; </script>";

$conn->close();
?>