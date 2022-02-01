<?php

header("Content-Type:application/json");
require('../config/connect.php');

$response = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
  $users = "SELECT id, name, email FROM users";
  $hasil = mysqli_query($conn, $users);
  if (mysqli_num_rows($hasil) > 0) {
    while ($row = $hasil->fetch_assoc()) {
      $response['error'] = '200';
      $response['users'][] = $row;
    }
  } else {
    $response['users'][] = "";
    $response['error'] = "400";
  }
} else {
  $response['error'] = '401';
  $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
mysqli_close($conn);
