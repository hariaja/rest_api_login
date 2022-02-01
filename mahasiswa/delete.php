<?php

header("Content-Type:application/json");
require('../config/connect.php');

$method = $_SERVER['REQUEST_METHOD'];
$response = array();

if ($method == 'POST') {

  $id = $_POST['id'];

  $cek_gambar = "SELECT * FROM mahasiswa WHERE id = '$id'";
  $execute = mysqli_query($conn, $cek_gambar);
  $result = mysqli_fetch_assoc($execute);
  if ($result['image'] != null) {
    unlink('../images/' . $result['image']);

    $delete = "DELETE FROM mahasiswa WHERE id = '$id'";
    $query = mysqli_query($conn, $delete);

    if ($query) {
      $response['error'] = '200';
      $response['message'] = 'Data Berhasil Dihapus';
    } else {
      $response['error'] = '403';
      $response['message'] = 'Data Gagal Dihapus';
    }
  } else {
    $delete = "DELETE FROM mahasiswa WHERE id = '$id'";
    $query = mysqli_query($conn, $delete);

    if ($query) {
      $response['error'] = '200';
      $response['message'] = 'Data Berhasil Dihapus';
    } else {
      $response['error'] = '403';
      $response['message'] = 'Data Gagal Dihapus';
    }
  }
} else {
  $response['error'] = '402';
  $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
mysqli_close($conn);
