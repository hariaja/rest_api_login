<?php

header("Content-Type:application/json");
require('../config/connect.php');

$response = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $check = "SELECT * FROM users WHERE email = '$email'";
  $hasil = mysqli_query($conn, $check);

  if (mysqli_num_rows($hasil) > 0) {

    $check_user_login = "SELECT id, name, email FROM users WHERE email = '$email' and password = '$password'";
    $hasil_check_login = mysqli_query($conn, $check_user_login);

    if (mysqli_num_rows($hasil_check_login) > 0) {
      while ($row = $hasil_check_login->fetch_assoc()) {
        $response['user'] = $row;
        $response['error'] = '200';
        $response['message'] = 'Login Berhasil';
      }
    } else {
      $response['user'] = (object) [];
      $response['error'] = '401';
      $response['message'] = 'Email atau Password salah';
    }
  } else {
    $response['user'] = (object) [];
    $response['error'] = '403';
    $response['message'] = 'Akun Tidak Tersedia';
  }
} else {
  $response['error'] = '401';
  $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
mysqli_close($conn);
