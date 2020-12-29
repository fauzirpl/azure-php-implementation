<?php
error_reporting(0);
session_start();
include 'koneksi.php';

require_once 'vendor/autoload.php';
require_once "random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$kategori = $_POST['kategori'];
$judul = $_POST['judul'];
$sinopsi = $_POST['sinopsis'];
$id = $_POST['id'];

$target_file = basename($_FILES["sampul"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$uploadOk = 1;

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  $_SESSION["error"] = "Upload gambar aja kau le, jangan maen2";
  $uploadOk = 0;
} 

if ($_FILES["sampul"]["size"] > 1000000) {
  $_SESSION["error"] = "Filenya besar kali";
  $uploadOk = 0;
} 


if($uploadOk == 1) {
  $connectionString = "DefaultEndpointsProtocol=https;AccountName=yourAccountName;AccountKey=yourAccountKey";
  $content = fopen($_FILES["sampul"]["tmp_name"], 'r');
  // Create blob client.
  $blobClient = BlobRestProxy::createBlobService($connectionString);
  $blobClient->createBlockBlob('buku', $target_file, $content);

  $listBlobsOptions = new ListBlobsOptions();
  $listBlobsOptions->setPrefix($target_file);

  $result = $blobClient->listBlobs('buku', $listBlobsOptions);
  $url = '';
  foreach($result->getBlobs() as $blob)
  {
      $url = $blob->getUrl();
  }

  $sql = "UPDATE buku SET judul = '$judul', kategori = '$kategori', sampul = '$url', sinopsi = '$sinopsi' WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    $_SESSION["sukses"] = TRUE;
  } else {
    $_SESSION["error"] = "Error: ${sql}" . $conn->error;
  }
} else {
  $sql = "UPDATE buku SET judul = '$judul', kategori = '$kategori', sinopsi = '$sinopsi' WHERE id = $id";
  
  if ($conn->query($sql) === TRUE) {
    $_SESSION["sukses"] = TRUE;
  } else {
    $_SESSION["error"] = "Error: ${sql}" . $conn->error;
  }
}

echo "<script> location.href='index.php'; </script>";

$conn->close();
?>