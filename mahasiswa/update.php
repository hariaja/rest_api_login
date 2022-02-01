<?php

header("Content-Type:application/json");
require('../config/connect.php');
define('UPLOAD_PATH', 'C:/laragon/www/my-apps/images/');

$response = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

  // tangkap id yang nantinya datanya akan diubah
  $id = $_POST['id'];

  // Menyiapkan Data Yang Akan di Upload
  $nim = $_POST['nim'];
  $name = $_POST['name'];
  $alamat = $_POST['alamat'];

  if (isset($_FILES['image']['name'])) {
    // Menyiapkan file gambar
    $gambar = $_FILES['image']['name'];
    $ext = explode('.', $gambar);
    $eksitensi = strtolower(end($ext));
    $new_image = time() . '.' . $eksitensi;

    $cek_gambar_lama = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $execute = mysqli_query($conn, $cek_gambar_lama);
    $data = mysqli_fetch_array($execute);

    if ('../images/' . $data['image']) {
      # code...
      unlink('../images/' . $data['image']);
    }

    $query = "UPDATE mahasiswa SET nim = '$nim', name = '$name', alamat = '$alamat', image = '$new_image' WHERE id = '$id'";
    $exe = mysqli_query($conn, $query);
    $check = mysqli_affected_rows($conn);

    // Menyimpan Foto Ke penyimpanan Local
    move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $new_image);

    if ($check > 0) {
      $response['error'] = '200';
      $response['message'] = 'Data Berhasil Diubah';
    } else {
      $response['error'] = '402';
      $response['message'] = 'Data gagal Diubah';
    }
  } else {
    echo "user tidak ingin merubah foto";
  }
} else {
  $response['error'] = '401';
  $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
mysqli_close($conn);
