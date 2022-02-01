<?php

header("Content-Type:application/json");
require('../config/connect.php');
define('UPLOAD_PATH', 'C:/laragon/www/my-apps/images/');

$response = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

  // Menyiapkan Data Yang Akan di Upload
  $nim = $_POST['nim'];
  $name = $_POST['name'];
  $alamat = $_POST['alamat'];

  // Menyiapkan file gambar
  $gambar = $_FILES['image']['name'];
  $ext = explode('.', $gambar);
  $eksitensi = strtolower(end($ext));
  $image = time() . '.' . $eksitensi;

  // Cek jika Ada Nim Yang Sama tidak diperbolehkan
  $cek_nim = "SELECT nim FROM mahasiswa WHERE nim = '$nim'";
  $result = mysqli_query($conn, $cek_nim);
  if (mysqli_num_rows($result) > 0) {
    # code...
    $response['error'] = '403';
    $response['message'] = 'Nim tersedia, Gunakan Nim Lain';
  } else {
    if (isset($gambar)) {
      // Membuat query Insert ke Database
      $query = "INSERT INTO mahasiswa(nim, name, alamat, image) VALUES('$nim', '$name', '$alamat', '$image')";
      $execute = mysqli_query($conn, $query);
      $data = mysqli_affected_rows($conn);
      // Menyimpan Foto Ke penyimpanan Local
      move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $image);
      if ($data > 0) {
        # code...
        $response['error'] = '200';
        $response['message'] = 'Data Berhasil Ditambahkan';
      } else {
        $response['error'] = '402';
        $response['message'] = 'Gagal Menyimpan Data';
      }
    } else {
      // Membuat query Insert ke Database
      $query = "INSERT INTO mahasiswa(nim, name, alamat, image) VALUES('$nim', '$name', '$alamat', null)";
      $execute = mysqli_query($conn, $query);
      $data = mysqli_affected_rows($conn);

      if ($data > 0) {
        # code...
        $response['error'] = '200';
        $response['message'] = 'Data Berhasil Ditambahkan';
      } else {
        $response['error'] = '402';
        $response['message'] = 'Gagal Menyimpan Data';
      }
    }
  }
} else {
  $response['error'] = '401';
  $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
mysqli_close($conn);
