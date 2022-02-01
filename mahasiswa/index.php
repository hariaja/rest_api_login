<?php

header("Content-Type:application/json");
require('../config/connect.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
  $query = "SELECT * FROM mahasiswa";
  $execute = mysqli_query($conn, $query);
  $cek_data = mysqli_affected_rows($conn);

  if ($cek_data > 0) {
    $response['error'] = '200';
    $response['message'] = 'Semua Data Mahasiswa';
    $response['data'] = array();

    while ($getData = mysqli_fetch_object($execute)) {
      $F['id'] = $getData->id;
      $F['nim'] = $getData->nim;
      $F['name'] = $getData->name;
      $F['alamat'] = $getData->alamat;
      $F['image'] = $getData->image;

      array_push($response['data'], $F);
    }
  } else {
    $response['error'] = '401';
    $response['message'] = 'Data Tidak Tersedia';
    $response['data'] = (object) [];
  }
} else {
  $response['error'] = '402';
  $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
mysqli_close($conn);
