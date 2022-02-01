<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbdb = "my_app_db";

$conn = new mysqli($host, $user, $pass, $dbdb);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
