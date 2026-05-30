<?php

$conn = new mysqli("localhost", "root", "", "online_leerplatform");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>