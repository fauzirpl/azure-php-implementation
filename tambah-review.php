<?php
session_start();
include 'koneksi.php';

$nama = $_POST['nama'];
$judul = $_POST['judul_buku'];
$review = $_POST['review'];

$sql = "INSERT INTO review (nama, judul, review)
VALUES ('$nama', '$judul', '$review')";

if ($conn->query($sql) === TRUE) {
  $_SESSION["sukses"] = TRUE;
  echo "<script> location.href='index.php'; </script>";
} else {
  echo "Error: ".$conn->error;
}

$conn->close();
?>